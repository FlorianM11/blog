<?php

require_once __DIR__ . '/../../../app/config/DbHandler.php';
require_once __DIR__ . '/../Entity/Article.php';

class ArticleRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = DbHandler::getDb();
    }

    public function findAll($query = null)
    {
        $results = $this->_db->prepare("SELECT *, article.id as id_article, users.id as id_users 
                                        FROM Article INNER JOIN users ON users.id = article.author_id 
                                        WHERE article.title like :query
                                        OR article.category like :query
                                        OR article.content like :query
                                        OR users.nom like :query
                                        OR users.prenom like :query 
                                        ORDER BY modifiedAt DESC");
        $results->execute([':query' => '%'.$query.'%']);

        $articles_from_table = $results->fetchAll();

        foreach ($articles_from_table as $article){
            $articleObj = $this->convertToObject($article);
            $articleObj->setId($article['id_article']);
            $articles[] = $articleObj;
        }

        return $articles;
    }

    public function findCategory($categorySearch = null)
    {
        if ($categorySearch !== null){
            $results = $this->_db->prepare("SELECT * , article.id as id_article, users.id as id_users 
                                            FROM Article INNER JOIN users ON users.id = article.author_id  WHERE category like :category");
            $results->execute([':category' => urldecode($categorySearch)]);

            $articles_from_table = $results->fetchAll();

            foreach ($articles_from_table as $article){
                $articleObj = $this->convertToObject($article);
                $articleObj->setId($article['id_article']);
                $articles[] = $articleObj;
            }

            return $articles;

        } else {
            $results = $this->_db->prepare("SELECT count(*), category FROM article GROUP BY category");
            $results->execute();

            $categories_array = $results->fetchAll();

            $categories = [];
            foreach ($categories_array as $key => $category){
                $categories[$key]['count'] = $category[0];
                $categories[$key]['name'] = $category[1];
            }

            return $categories;
        }




    }


    public function deleteArticle($id, Users $author)
    {
        $results = $this->_db->prepare("DELETE FROM article WHERE id = :id AND author_id = :author_id");
        $results->execute([
            ':id' => $id,
            ':author_id' => $author->getId()
        ]);

        if ($results->rowCount() !== 0) {
            return true;
        }

        return false;
    }

    public function addArticle(Article $article)
    {
        $result = $this->_db->prepare(
            "INSERT INTO article (author_id, title, category, content, createdAt, modifiedAt) 
          VALUE (:id, :title, :category, :content, :createdAt, :modifiedAt)");

        $result->execute([
            ':id' => $article->getAuthor()->getId(),
            ':title' => $article->getTitle(),
            ':category' => $article->getCategory(),
            ':content' => $article->getContent(),
            ':createdAt' => $article->getCreatedAt(),
            ':modifiedAt' => $article->getModifiedAt()
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    public function editArticle(Article $article, Users $author)
    {
        $result = $this->_db->prepare("UPDATE article SET title = :title, category = :category, content = :content, modifiedAt = :modifiedAt 
                                        WHERE id = :id AND author_id = :author_id");
        $result->execute([
            ':title' => $article->getTitle(),
            ':category' => $article->getCategory(),
            ':content' => $article->getContent(),
            ':modifiedAt' => date('Y-m-d'),
            ':id' => $article->getId(),
            ':author_id' => $author->getId()
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    public function findOneById($id, Users $author)
    {
        $results = $this->_db->prepare("SELECT *, article.id as id_article, users.id as id_users 
                                        FROM Article INNER JOIN users ON users.id = article.author_id 
                                        WHERE article.id = :id AND article.author_id = :author_id");
        $results->execute([
            ':id' => $id,
            ':author_id' => $author->getId()
        ]);

        $articles_from_tables = $results->fetchAll();

        $count = count($articles_from_tables);

        if ($count === 1) {
            return $this->convertToObject($articles_from_tables[0]);
        }

        return false;
    }

    private function convertToObject(array $article)
    {
        $author = new Users(
            $article['nom'],
            $article['prenom'],
            $article['pseudo'],
            $article['password']
        );

        $articleObj = new Article(
            $author,
            $article['title'],
            $article['category'],
            $article['content']);

        $articleObj->setModifiedAt($article['modifiedAt']);
        $articleObj->setCreatedAt($article['createdAt']);

        return $articleObj;
    }
}
