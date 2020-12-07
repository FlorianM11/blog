<?php

require_once __DIR__ . "/../../src/BlogBundle/Controller/MainController.php";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$mainCtrl = new MainController();

switch ($request) {
    case '/':
        $response = $mainCtrl->homeAction(isset($_GET['query']) ? $_GET['query'] : null);
        break;
    case '/searchCat':
        $response = $mainCtrl->searchCatAction(isset($_GET['query']) ? $_GET['query'] : null);
        break;
    case '/searchById':
        $json = $mainCtrl->searchByIdAction($_POST['article_id']);
        break;
    case '/login':
        $response = $mainCtrl->loginAction();
        break;
    case '/logout':
        $response = $mainCtrl->logoutAction();
        break;
    case '/inscription':
        $response = $mainCtrl->inscriptionAction();
        break;
    case '/validateInscription':
        $response = $mainCtrl->validateInscriptionAction();
        break;
    case '/verificationLogin':
        $response = $mainCtrl->validationLoginAction();
        break;
    case '/add-article':
        $response = $mainCtrl->displayFormAddArticle();
        break;
    case '/addArticle':
        $response = $mainCtrl->addArticlesAction();
        break;
    case '/admin':
        $response = $mainCtrl->adminAction();
        break;
    case '/deleteArticle':
        $response = $mainCtrl->deleteArticle($_GET['id']);
        break;
    case '/editArticle':
        $response = $mainCtrl->editArticle($_GET['id']);
        break;
    case '/validateEdit':
        $response = $mainCtrl->validateEdit($_GET['id']);
        break;
    default:
        $response = $mainCtrl->notFoundAction();
}
