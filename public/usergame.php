<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/UserGameController.php';

$controller = new UserGameController();

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $controller->handleAdd();
} elseif ($action === 'remove') {
    $controller->handleRemove();
} else {
    header('Location: ' . BASE_URL . 'game.php');
    exit;
}