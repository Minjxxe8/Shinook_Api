<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/ProfileController.php';

$controller = new ProfileController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleUpdate();
} else {
    $controller->showProfile();
}

