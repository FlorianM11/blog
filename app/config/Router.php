<?php

require_once __DIR__ . "/../../src/BlogBundle/Controller/MainController.php";

$request = $_SERVER['REQUEST_URI'];
$mainCtrl = new MainController();

if (isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id = null;
}

if (isset($_GET['query'])){
    $query = $_GET['query'];
    $home_route = '/?query=';
} else {
    $query = null;
    $home_route = '/';
}

switch ($request) {
    case $home_route.$query:
        $response = $mainCtrl->homeAction();
        break;
    case '/searchCat?query='.urlencode($query):
        $response = $mainCtrl->searchCatAction($query);
        break;
    case '/login':
        $response = $mainCtrl->loginAction();
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
    case '/deleteArticle?id=' . $id:
        $response = $mainCtrl->deleteArticle($id);
        break;
    case '/editArticle?id=' . $id:
        $response = $mainCtrl->editArticle($id);
        break;
    case '/validateEdit?id=' . $id:
        $response = $mainCtrl->validateEdit($id);
        break;
    default:
        $response = $mainCtrl->notFoundAction();
}
