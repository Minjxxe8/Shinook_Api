<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'darksouls_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('BASE_URL', 'http://localhost/shinook/public/');
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
