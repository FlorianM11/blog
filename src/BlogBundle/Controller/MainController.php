<?php

require_once __DIR__ . '/../Repository/ArticleRepository.php';
require_once __DIR__ . '/../Repository/UsersRepository.php';
require_once __DIR__ . '/Controller.php';

class MainController extends Controller
{
    private $path_of_views = __DIR__ . "/../Resources/views";

    /**
     * @var false|Users
     */
    private $user;

    public function __construct()
    {
        if ($this->sessionExist('id_user')){
            $this->user = (new UsersRepository())->findUserById($this->getSession('id_user'));

            if ($this->user){
                $this->user->setId($this->getSession('id_user'));
            } else {
                return $this->returnRedirect('/logout');
            }
        }
    }

    public function homeAction($query = null)
    {
        $articles = (new ArticleRepository())->findAll($query);
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

    public function logoutAction()
    {
        session_destroy();
        return $this->returnRedirect('/');
    }

    public function validationLoginAction()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        $user = (new UsersRepository())->findUser($pseudo, $password);

        if ($user) {
            $this->setSession('ROLE', 'USER');
            $this->setSession('id_user', $user->getId());
            return $this->returnRedirect('/');
        } else {
            $this->setSession('error', 'Les identifiants sont incorrects');
            return $this->returnRedirect('/login');
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
            return $this->returnRedirect('/login');
        } else {
            $this->setSession('error', 'Une erreur est survenue lors de votre inscription');
            return $this->returnRedirect('/inscription');
        }
    }

    public function addArticlesAction()
    {
        $newArticle = new Article($this->user, $_POST['title'], $_POST['category'], $_POST['content']);
        $result = (new ArticleRepository())->addArticle($newArticle);

        if ($result === true) {
            return $this->returnRedirect('/');
        } else {
            $this->setSession('error', "Une erreur est survenue lors de l'ajout de votre article");
            return $this->returnRedirect('/admin');
        }
    }

    public function adminAction()
    {

        $articles = (new ArticleRepository())->findAll(null, $this->user);

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

        if ($result === false) {
            $this->setSession('error', "Une erreur est survenue lors de la suppression de l'article");
        }

        return $this->returnRedirect('/admin');
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

        $editArticle = (new ArticleRepository())->editArticle($article, $this->user);

        if ($editArticle === false) {
            $this->setSession('error', "Une erreur est survenue lors de la modification de l'article");
        }

        return $this->returnRedirect('/admin');
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

    public function searchByIdAction($article_id)
    {
        $article = (new ArticleRepository())->findOneById($article_id);

        if ($article) {
            return $this->returnJson($article, $article->getAuthor());
        }
    }
}
