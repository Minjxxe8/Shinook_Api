<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/AdminController.php';

$controller = new AdminController();

$action = $_POST['action'] ?? '';
$type   = $_POST['type']   ?? '';

if ($type === 'user') {
    $controller->handleBanUser();
} elseif ($type === 'game') {
    $controller->handleBanGame();
} else {
    header('Location: ' . BASE_URL . 'profile.php');
    exit;
}

