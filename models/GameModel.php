<?php

require_once ROOT_PATH . '/core/Model.php';

class GameModel extends Model
{
    protected string $table = 'game';

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM games ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}