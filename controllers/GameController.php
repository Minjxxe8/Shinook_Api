<?php

require_once ROOT_PATH . '/models/GameModel.php';

class GameController
{
    private GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    public function showGames(): void
    {
        $games = $this->gameModel->findAll();
        require ROOT_PATH . '/views/game/game.php';
    }
}