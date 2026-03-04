<?php

require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/models/ProfileModel.php';
require_once ROOT_PATH . '/models/GameModel.php';

class AdminController
{
    private ProfileModel $userModel;
    private GameModel $gameModel;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->userModel = new ProfileModel();
        $this->gameModel = new GameModel();
    }

    public function handleBanUser(): void
    {
        Auth::requireAdmin();

        $targetId = (int)($_POST['user_id'] ?? 0);
        $action = $_POST['action'] ?? '';

        if ($targetId <= 0) {
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        // Empêcher de se bannir soi-même
        if ($targetId === (int)Auth::currentUser()['id']) {
            header('Location: ' . BASE_URL . 'profile.php?admin_error=self');
            exit;
        }

        $target = $this->userModel->findById($targetId);
        if (!$target) {
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        if ($target['role'] === ROLE_ADMIN) {
            header('Location: ' . BASE_URL . 'profile.php?admin_error=admin');
            exit;
        }

        if ($action === 'ban') {
            $this->userModel->setBanned($targetId, 1);
        } elseif ($action === 'unban') {
            $this->userModel->setBanned($targetId, 0);
        }

        header('Location: ' . BASE_URL . 'profile.php#admin');
        exit;
    }

    public function handleBanGame(): void
    {
        Auth::requireAdmin();

        $gameId = (int)($_POST['game_id'] ?? 0);
        $action = $_POST['action'] ?? '';

        if ($gameId <= 0) {
            header('Location: ' . BASE_URL . 'profile.php');
            exit;
        }

        if ($action === 'ban') {
            $this->gameModel->setBanned($gameId, 1);
        } elseif ($action === 'unban') {
            $this->gameModel->setBanned($gameId, 0);
        }

        header('Location: ' . BASE_URL . 'profile.php#admin');
        exit;
    }
}

