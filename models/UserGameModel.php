<?php

require_once ROOT_PATH . '/core/Model.php';

class UserGameModel extends Model
{
    protected string $table = 'users_game';

    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT ug.*, g.name, g.genre, g.year, g.rating, g.difficulty, g.price
            FROM users_game ug
            JOIN games g ON g.id = ug.game_id
            WHERE ug.user_id = :user_id
            ORDER BY ug.purchase_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findByUserAndGame(int $userId, int $gameId): array|false
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users_game 
            WHERE user_id = :user_id AND game_id = :game_id
        ");
        $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
        return $stmt->fetch();
    }

    public function add(int $userId, int $gameId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users_game (user_id, game_id, purchase_at)
            VALUES (:user_id, :game_id, CURRENT_TIMESTAMP)
        ");
        return $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    }

    public function removeByUserAndGame(int $userId, int $gameId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM users_game 
            WHERE user_id = :user_id AND game_id = :game_id
        ");
        return $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    }
}