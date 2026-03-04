<?php
/**
 * Script temporaire — crée le compte admin dans la BDD
 * À supprimer après utilisation !
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

$db = Database::getInstance();

$username = 'TomNook';
$email    = 'admin@shinook.fr';
$password = 'Admin1234!';
$role     = ROLE_ADMIN;
$hash     = password_hash($password, PASSWORD_BCRYPT);

// Vérifier si le compte existe déjà
$check = $db->prepare("SELECT id FROM users WHERE email = :email");
$check->execute(['email' => $email]);
$existing = $check->fetch();

if ($existing) {
    // Mettre à jour le rôle au cas où
    $stmt = $db->prepare("UPDATE users SET role = :role, banned = 0 WHERE email = :email");
    $stmt->execute(['role' => $role, 'email' => $email]);
    echo "✅ Compte admin mis à jour.\n";
} else {
    $stmt = $db->prepare(
        "INSERT INTO users (username, email, password, role, banned, created_at)
         VALUES (:username, :email, :password, :role, 0, CURRENT_TIMESTAMP)"
    );
    $stmt->execute([
        'username' => $username,
        'email'    => $email,
        'password' => $hash,
        'role'     => $role,
    ]);
    echo "✅ Compte admin créé avec succès !\n";
}

echo "\n--- Identifiants ---\n";
echo "Email    : $email\n";
echo "Password : $password\n";
echo "Rôle     : $role\n";
echo "\n⚠️  Supprime ce fichier après utilisation !\n";

