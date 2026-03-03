<?php

require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/models/ProfileModel.php';

class AuthController
{
    private ProfileModel $userModel;

    public function __construct()
    {
        $this->userModel = new ProfileModel();
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

    public function handleLogin(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';
        $errors   = [];

        if (empty($email) || empty($password)) {
            $errors[] = 'Tous les champs sont requis.';
        }

        if (empty($errors)) {
            $user = $this->userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = 'Email ou mot de passe incorrect.';
            }
        }

        if (empty($errors)) {
            Auth::login($user);
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        require ROOT_PATH . '/views/auth/login.php';
    }

    public function handleLogout(): void
    {
        Auth::logout();
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    public function handleDeleteProfile(): void
    {
        Auth::requireLogin();


        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        $errors   = [];

        $currentUser = Auth::currentUser();
        $user        = $this->userModel->findById($currentUser['id']);

        if (empty($password)) {
            $errors[] = 'Veuillez confirmer votre mot de passe.';
        } elseif ($email !== $user['email']) {
            $errors[] = 'Email incorrect.';
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = 'Mot de passe incorrect.';
        }

        if (empty($errors)) {
            $this->userModel->delete($currentUser['id']);
            Auth::logout();
            header('Location: ' . BASE_URL . 'register.php');
            exit;
        }

        require ROOT_PATH . '/views/auth/profile.php';
    }

}