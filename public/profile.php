<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/controllers/ProfileController.php';

$controller = new ProfileController();
$controller->showProfile();

