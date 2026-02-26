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
        $id = (int)$this->db->lastInsertId();
        error_log('Last insert ID: ' . $id);
        error_log('DB file: ' . ROOT_PATH . '/sql/database.sqlite');
        error_log('DB exists: ' . (file_exists(ROOT_PATH . '/sql/database.sqlite') ? 'yes' : 'no'));

        return $id;
    }

}