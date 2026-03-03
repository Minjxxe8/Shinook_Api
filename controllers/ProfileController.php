<?php

require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/models/UserModel.php';
//require_once ROOT_PATH . '/models/UserGameModel.php';
//require_once ROOT_PATH . '/models/GameModel.php';

class ProfileController
{
    private UserModel $userModel;
    //private UserGameModel $userGameModel;
    //private GameModel $gameModel;

    public function __construct()
    {
        Auth::requireLogin();
        $this->userModel = new UserModel();
        //$this->userGameModel = new UserGameModel();
        //$this->gameModel = new GameModel();
    }

    public function show(): void
    {
        $currentUser = Auth::currentUser();
        $userInfo = $this->userModel->findById($currentUser['id']);
       /* $userGames = $this->userGameModel->findByUser($currentUser['id']);
        $achievements = $this->userGameModel->getUserAchievements($currentUser['id']);
        $allGames = $this->gameModel->findAll();*/

        require ROOT_PATH . '/views/profile/profile.php';
    }

    public function updateProfile(): void
    {
        $currentUser = Auth::currentUser();
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $errors = [];

        if (empty($username) || empty($email)) {
            $errors[] = 'Champs requis.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }

        if (empty($errors)) {
            $this->userModel->updateProfile($currentUser['id'], $username, $email);
            $_SESSION['username'] = $username;
            $_SESSION['flash'] = 'Profil mis à jour, Chosen Undead.';
        } else {
            $_SESSION['errors'] = $errors;
        }

        header('Location: ' . BASE_URL . 'profile.php');
        exit;
    }

    /*public function addGame(): void
    {
        $currentUser = Auth::currentUser();
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gameId > 0) {
            $this->userGameModel->addGame($currentUser['id'], $gameId);
            $_SESSION['flash'] = 'Jeu ajouté à votre bibliothèque de feu de camp.';
        }

        header('Location: ' . BASE_URL . 'profile.php');
        exit;
    }

    public function removeGame(): void
    {
        $currentUser = Auth::currentUser();
        $id = (int)($_POST['user_game_id'] ?? 0);
        $this->userGameModel->removeGame($id, $currentUser['id']);
        $_SESSION['flash'] = 'Jeu retiré.';
        header('Location: ' . BASE_URL . 'profile.php');
        exit;
    }*/
}
