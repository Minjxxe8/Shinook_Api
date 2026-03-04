<?php

require_once ROOT_PATH . '/core/Model.php';

class TrophyModel extends Model
{
    protected string $table = 'trophies';


    public function findByGame(int $gameId): array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, icon, description
            FROM trophies
            WHERE game_id = :game_id
            ORDER BY id ASC
        ");
        $stmt->execute(['game_id' => $gameId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les IDs de trophées déjà obtenus par un utilisateur pour un jeu donné.
     */
    public function findEarnedByUserAndGame(int $userId, int $gameId): array
    {
        $stmt = $this->db->prepare("
            SELECT t.id
            FROM users_trophies ut
            JOIN trophies t ON t.id = ut.trophy_id
            WHERE ut.user_id = :user_id AND t.game_id = :game_id
        ");
        $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
        return array_column($stmt->fetchAll(), 'id');
    }

    /**
     * Récupère tous les trophées obtenus par un utilisateur, groupés par game_id.
     */
    public function findAllEarnedByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT t.id, t.game_id
            FROM users_trophies ut
            JOIN trophies t ON t.id = ut.trophy_id
            WHERE ut.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $rows = $stmt->fetchAll();

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[(int)$row['game_id']][] = (int)$row['id'];
        }
        return $grouped;
    }
}

