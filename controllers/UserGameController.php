<?php

require_once ROOT_PATH . '/models/UserGameModel.php';
require_once ROOT_PATH . '/core/Auth.php';

class UserGameController
{
    private UserGameModel $userGameModel;

    private function getSafeRedirect(string $default = 'game.php'): string
    {
        $allowed = ['game.php', 'profile.php'];
        $redirect = $_POST['redirect'] ?? $default;
        if (!in_array($redirect, $allowed, true)) {
            $redirect = $default;
        }
        return BASE_URL . $redirect;
    }

    public function __construct()
    {
        $this->userGameModel = new UserGameModel();
    }

    public function handleAdd(): void
    {
        Auth::requireLogin();
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gameId <= 0) {
            header('Location: ' . $this->getSafeRedirect('game.php'));
            exit;
        }

        if (!$this->userGameModel->findByUserAndGame(Auth::currentUser()['id'], $gameId)) {
            $this->userGameModel->add(Auth::currentUser()['id'], $gameId);
        }

        header('Location: ' . $this->getSafeRedirect('game.php'));
        exit;
    }

    public function handleRemove(): void
    {
        Auth::requireLogin();
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gameId <= 0) {
            header('Location: ' . $this->getSafeRedirect('profile.php'));
            exit;
        }

        $this->userGameModel->removeByUserAndGame(Auth::currentUser()['id'], $gameId);
        header('Location: ' . $this->getSafeRedirect('profile.php'));
        exit;
    }
}