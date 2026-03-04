<?php

// Détection automatique de BASE_URL pour éviter les boucles de redirection
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
define('BASE_URL', $scheme . '://' . $host . '/');
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
