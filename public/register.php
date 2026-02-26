<?php

define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/controllers/AuthController.php';

$controller = new AuthController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRegister();
} else {
    //$controller->showRegister();
    require ROOT_PATH . '/views/auth/register.php';
}
