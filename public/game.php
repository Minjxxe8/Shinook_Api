<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/GameController.php';

$controller = new GameController();
$controller->showGames();