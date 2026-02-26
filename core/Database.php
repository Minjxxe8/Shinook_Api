<?php

require_once ROOT_PATH . '/config/config.php';

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $databasePath = ROOT_PATH . '/sql/database.sqlite';

            $dsn = 'sqlite:' . $databasePath;

            try {
                self::$instance = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

                $initFile = ROOT_PATH . '/sql/init.sql';
                if (file_exists($initFile)) {
                    self::$instance->exec(file_get_contents($initFile));
                }
            } catch (PDOException $e) {
                die('Connexion échouée : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }


}