<?php

require_once ROOT_PATH . '/models/GameModel.php';
require_once ROOT_PATH . '/models/UserGameModel.php';
require_once ROOT_PATH . '/models/TrophyModel.php';
require_once ROOT_PATH . '/core/Auth.php';

class GameController
{
    private GameModel $gameModel;
    private UserGameModel $userGameModel;
    private TrophyModel $trophyModel;

    public function __construct()
    {
        $this->gameModel     = new GameModel();
        $this->userGameModel = new UserGameModel();
        $this->trophyModel   = new TrophyModel();
    }

    public function showGames(): void
    {
        $games = $this->gameModel->findAll();

        $ownedGameIds    = [];
        $earnedTrophies  = []; // [ game_id => [trophy_id, ...] ]

        if (Auth::isLoggedIn()) {
            $userId          = Auth::currentUser()['id'];
            $ownedGames      = $this->userGameModel->findByUser($userId);
            $ownedGameIds    = array_column($ownedGames, 'game_id');
            $earnedTrophies  = $this->trophyModel->findAllEarnedByUser($userId);
        }

        // Charger les trophées pour chaque jeu
        $trophiesByGame = [];
        foreach ($games as $game) {
            $trophiesByGame[(int)$game['id']] = $this->trophyModel->findByGame((int)$game['id']);
        }

        require ROOT_PATH . '/views/game/game.php';
    }
}

