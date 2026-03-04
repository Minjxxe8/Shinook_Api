<?php


require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/core/Model.php';

class ProfileModel extends Model
{
    protected string $table = 'users';

    public function findByUsername(string $username): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create(string $username, string $email, string $password): int
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, role, created_at)
             VALUES (:username, :email, :password, :role, CURRENT_TIMESTAMP)"
        );
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hash,
            'role' => ROLE_USER,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $username, string $email, ?string $newPassword): bool
    {
        if ($newPassword !== null) {
            $hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("
            UPDATE users 
            SET username = :username, email = :email, password = :password
            WHERE id = :id
        ");
            return $stmt->execute([
                'username' => $username,
                'email'    => $email,
                'password' => $hash,
                'id'       => $id,
            ]);
        }

        $stmt = $this->db->prepare("
        UPDATE users 
        SET username = :username, email = :email
        WHERE id = :id
    ");
        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'id'       => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT id, username, email, role, banned, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function setBanned(int $id, int $banned): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET banned = :banned WHERE id = :id");
        return $stmt->execute(['banned' => $banned, 'id' => $id]);
    }

}