<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/Router.php';

$urlExclu = ['/login', '/inscription'];

if (!in_array($request, $urlExclu) && !isset($_SESSION['ROLE'])){
    header("Location: /login");
} else if ($request === "/login" && isset($_SESSION['ROLE'])) {
    header("Location: /");
}

$view = $response['view'];
if (isset($response['attributes'])) {
    $attributes = $response['attributes'];
}


require_once "../src/BlogBundle/Resources/template/header.php";
require_once $view;
require_once "../src/BlogBundle/Resources/template/footer.php";
