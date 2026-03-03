<?php


require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/core/Model.php';

class UserModel extends Model
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

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}