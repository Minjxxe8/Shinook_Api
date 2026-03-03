<?php

require_once ROOT_PATH . '/models/UserGameModel.php';
require_once ROOT_PATH . '/core/Auth.php';

class UserGameController
{
    private UserGameModel $userGameModel;

    public function __construct()
    {
        $this->userGameModel = new UserGameModel();
    }

    public function handleAdd(): void
    {
        Auth::requireLogin();
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gameId <= 0) {
            header('Location: ' . BASE_URL . 'game.php');
            exit;
        }

        if (!$this->userGameModel->findByUserAndGame(Auth::currentUser()['id'], $gameId)) {
            $this->userGameModel->add(Auth::currentUser()['id'], $gameId);
        }

        header('Location: ' . BASE_URL . 'game.php');
        exit;
    }

    public function handleRemove(): void
    {
        Auth::requireLogin();
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gameId <= 0) {
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        $this->userGameModel->removeByUserAndGame(Auth::currentUser()['id'], $gameId);
        header('Location: ' . BASE_URL . 'profile.php');
        exit;
    }
}