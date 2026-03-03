<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/ProfileController.php';

$controller = new ProfileController();
$action     = $_GET['action'] ?? 'show';

match ($action) {
    'update'      => $controller->updateProfile(),
    'add_game'    => $controller->addGame(),
    'remove_game' => $controller->removeGame(),
    default       => $controller->show(),
};

