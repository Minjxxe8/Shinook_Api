<?php

require_once ROOT_PATH . '/models/GameModel.php';
require_once ROOT_PATH . '/models/UserGameModel.php';
require_once ROOT_PATH . '/core/Auth.php';

class GameController
{
    private GameModel $gameModel;
    private UserGameModel $userGameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
        $this->userGameModel = new UserGameModel();
    }

    public function showGames(): void
    {
        $games = $this->gameModel->findAll();

        $ownedGameIds = [];
        if (Auth::isLoggedIn()) {
            $ownedGames   = $this->userGameModel->findByUser(Auth::currentUser()['id']);
            $ownedGameIds = array_column($ownedGames, 'game_id');
        }

        require ROOT_PATH . '/views/game/game.php';
    }
}