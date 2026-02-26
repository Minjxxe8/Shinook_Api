<?php

require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/models/UserModel.php';

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function handleRegister(): void
    {
        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email']    ?? '');
        $password  = $_POST['password']      ?? '';
        $confirm   = $_POST['confirm']       ?? '';
        $errors    = [];

        if (empty($username) || empty($email) || empty($password)) {
            $errors[] = 'Tous les champs sont requis.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if ($this->userModel->findByUsername($username)) {
            $errors[] = 'Ce nom de Chosen Undead est déjà pris.';
        }
        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (empty($errors)) {
            $id = $this->userModel->create($username, $email, $password);
            $user = $this->userModel->findById($id);
            Auth::login($user);
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        require ROOT_PATH . '/views/auth/register.php';
    }

}