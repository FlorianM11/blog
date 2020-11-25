<?php

require_once __DIR__ . '/../Repository/ArticleRepository.php';
require_once __DIR__ . '/../Repository/UsersRepository.php';

class MainController
{
    private $path_of_views = __DIR__ . "/../Resources/views";

    public function __construct()
    {
        if (isset($_SESSION['id_user'])){
            $this->user = (new UsersRepository())->findUserById($_SESSION['id_user']);
            $this->user->setId($_SESSION['id_user']);
        }
    }

    public function homeAction()
    {
        $articles = (new ArticleRepository())->findAll();
        $categories = (new ArticleRepository())->findCategory();

        $response = array(
            "view" => $this->path_of_views . "/home.php",
            "attributes" => [
                "articles" => $articles,
                "categories" => $categories
            ]
        );

        return $response;
    }

    public function loginAction()
    {
        $response = array(
            "view" => $this->path_of_views . "/login.php"
        );

        return $response;
    }

    public function validationLoginAction()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        $result = (new UsersRepository())->findUser($pseudo, $password);

        if ($result !== false) {
            $_SESSION['ROLE'] = 'USER';
            $_SESSION['id_user'] = $result[0]['id'];
            header('Location: /');
        } else {
            $_SESSION['error'] = "Les identifiants sont incorrects";
            header('Location: /login');
        }
    }

    public function inscriptionAction()
    {
        $response = array(
            "view" => $this->path_of_views . "/inscription.php"
        );

        return $response;
    }

    public function validateInscriptionAction()
    {
        $newUser = new Users($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['password']);
        $result = (new UsersRepository())->addUser($newUser);

        if ($result === true) {
            header('Location: /login');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de votre inscription";
            header('Location: /inscription');
        }
    }

    public function addArticlesAction()
    {
        $newArticle = new Article($this->user, $_POST['title'], $_POST['category'], $_POST['content']);
        $result = (new ArticleRepository())->addArticle($newArticle);

        if ($result === true) {
            header('Location: /');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de l'ajout de votre article";
            header('Location: /admin');
        }
    }

    public function adminAction()
    {

        $articles = (new ArticleRepository())->findAll();

        $response = array(
            "view" => $this->path_of_views . "/admin.php",
            "attributes" => [
                "articles" => $articles
            ]
        );

        return $response;
    }

    public function deleteArticle($id)
    {
        $result = (new ArticleRepository())->deleteArticle($id, $this->user);

        if ($result === true) {
            header('Location: /admin');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la suppression de l'article";
            header('Location: /admin');
        }
    }

    public function notFoundAction()
    {
        $response = array(
            "view" => $this->path_of_views . "/404.php",
            "attributes" => []
        );
        return $response;
    }

    public function editArticle($id)
    {
        $article = (new ArticleRepository())->findOneById($id, $this->user);

        if ($article){
            $article->setId($id);

            $response = array(
                "view" => $this->path_of_views . "/edit_article.php",
                "attributes" => [
                    "article" => $article
                ]
            );
            return $response;
        }
        return $this->notFoundAction();
    }

    public function validateEdit($id)
    {
        $article = new Article($this->user, $_POST['title'], $_POST['category'], $_POST['content']);

        $article->setId($id);

        $editArticle = (new ArticleRepository())->editArticle($article, $this->user);

        if ($editArticle === true) {
            header('Location: /admin');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la modification de l'article";
            header('Location: /admin');
        }
    }

    public function displayFormAddArticle()
    {
        $response = array(
            "view" => $this->path_of_views . "/add_article.php",
            "attributes" => []
        );
        return $response;
    }

    public function searchCatAction($category)
    {
        $articles = (new ArticleRepository())->findCategory($category);
        $categories = (new ArticleRepository())->findCategory();

        $response = array(
            "view" => $this->path_of_views . "/home.php",
            "attributes" => [
                "articles" => $articles,
                "categories" => $categories
            ]
        );

        return $response;
    }
}
