<?php

require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/models/ProfileModel.php';
require_once ROOT_PATH . '/models/UserGameModel.php';
require_once ROOT_PATH . '/models/GameModel.php';

class ProfileController
{
    private ProfileModel $userModel;
    private UserGameModel $userGameModel;
    private GameModel $gameModel;

    public function __construct()
    {
        Auth::requireLogin();
        $this->userModel = new ProfileModel();
        $this->userGameModel = new UserGameModel();
        //$this->gameModel = new GameModel();
    }

    public function showProfile(): void
    {
        Auth::requireLogin();

        $currentUser = Auth::currentUser();
        $user = $this->userModel->findById($currentUser['id']);
        $games = $this->userGameModel->findByUser($currentUser['id']);
        $errors = [];
        /*$achievements = $this->userGameModel->getUserAchievements($currentUser['id']);
        $allGames = $this->gameModel->findAll();*/

        require ROOT_PATH . '/views/profile/profile.php';
    }

    public function handleUpdate(): void
    {
        Auth::requireLogin();

        $username        = trim($_POST['username']         ?? '');
        $email           = trim($_POST['email']            ?? '');
        $password        = $_POST['password']              ?? '';
        $newPassword     = $_POST['new_password']          ?? '';
        $confirmPassword = $_POST['confirm_password']      ?? '';
        $errors          = [];

        $user = $this->userModel->findById(Auth::currentUser()['id']);


        if (!password_verify($password, $user['password'])) {
            $errors[] = 'Mot de passe actuel incorrect.';
        }

        if (empty($username)) {
            $errors[] = 'Le nom d\'utilisateur est requis.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }

        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser && $existingUser['id'] !== $user['id']) {
            $errors[] = 'Ce nom d\'utilisateur est déjà pris.';
        }

        $existingEmail = $this->userModel->findByEmail($email);
        if ($existingEmail && $existingEmail['id'] !== $user['id']) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (!empty($newPassword)) {
            if (strlen($newPassword) < 8) {
                $errors[] = 'Le nouveau mot de passe doit contenir au moins 8 caractères.';
            }
            if ($newPassword !== $confirmPassword) {
                $errors[] = 'Les nouveaux mots de passe ne correspondent pas.';
            }
        }

        if (empty($errors)) {
            $this->userModel->update(
                $user['id'],
                $username,
                $email,
                !empty($newPassword) ? $newPassword : null
            );

            $_SESSION['username'] = $username;

            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        $games = $this->userGameModel->findByUser($user['id']);
        require ROOT_PATH . '/views/profile/profile.php';
    }
}
