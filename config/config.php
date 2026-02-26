<?php

define('BASE_URL', 'http://localhost:8000/');
define('ROOT_PATH', dirname(__DIR__));

define('ROLE_USER',  'villageois');
define('ROLE_ADMIN', 'Team Nook');

// Démarrage de session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 3600,
        'path'     => '/',
        'secure'   => false,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}
