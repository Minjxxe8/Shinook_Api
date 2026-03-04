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

                // Migrations : ajout des colonnes si elles n'existent pas encore
                $migrations = [
                    "ALTER TABLE users ADD COLUMN banned INTEGER DEFAULT 0",
                    "ALTER TABLE games ADD COLUMN banned INTEGER DEFAULT 0",
                ];
                foreach ($migrations as $migration) {
                    try {
                        self::$instance->exec($migration);
                    } catch (PDOException $e) {
                        // La colonne existe déjà, on ignore
                    }
                }
            } catch (PDOException $e) {
                die('Connexion échouée : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }


}