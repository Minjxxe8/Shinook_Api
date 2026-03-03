<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/AuthController.php';

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleLogin();
} else {
    require ROOT_PATH . '/views/auth/login.php';
}