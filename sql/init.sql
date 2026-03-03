CREATE TABLE IF NOT EXISTS users (
     id         INTEGER PRIMARY KEY AUTOINCREMENT,
     username   TEXT NOT NULL,
     email      TEXT UNIQUE NOT NULL,
     password   TEXT NOT NULL,
     role       TEXT DEFAULT 'villageois',
     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS games (
     id          INTEGER PRIMARY KEY AUTOINCREMENT,
     name        TEXT NOT NULL,
     genre       TEXT NOT NULL,
     year        INTEGER NOT NULL,
     rating      REAL DEFAULT 0,
     difficulty  INTEGER DEFAULT 1,
     description TEXT,
     price       REAL NOT NULL,
     picture     TEXT,
     created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS levels (
      id          INTEGER PRIMARY KEY AUTOINCREMENT,
      game_id     INTEGER NOT NULL,
      name        TEXT NOT NULL,
      difficulty  INTEGER DEFAULT '1',
      description TEXT,
      created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (game_id) REFERENCES games(id)
);

CREATE TABLE IF NOT EXISTS trophies (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    name        TEXT NOT NULL,
    game_id     INTEGER NOT NULL,
    level_id    INTEGER NOT NULL,
    description TEXT,
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (level_id) REFERENCES levels(id)
);

CREATE TABLE IF NOT EXISTS users_game (
     id               INTEGER PRIMARY KEY AUTOINCREMENT,
     user_id          INTEGER NOT NULL,
     game_id          INTEGER NOT NULL,
     playtime_hour    INTEGER DEFAULT 0,
     purchase_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(id),
     FOREIGN KEY (game_id) REFERENCES games(id)
);


CREATE TABLE IF NOT EXISTS users_levels (
     id          INTEGER PRIMARY KEY AUTOINCREMENT,
     user_id     INTEGER NOT NULL,
     level_id    INTEGER NOT NULL,
     game_id     INTEGER NOT NULL,
     completed   INTEGER DEFAULT 0,
     achieved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(id),
     FOREIGN KEY (level_id) REFERENCES levels(id),
     FOREIGN KEY (game_id) REFERENCES games(id)
);

CREATE TABLE IF NOT EXISTS users_trophies (
     id          INTEGER PRIMARY KEY AUTOINCREMENT,
     user_id     INTEGER NOT NULL,
     trophy_id   INTEGER NOT NULL,
     achieved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(id),
     FOREIGN KEY (trophy_id) REFERENCES trophies(id)
);

INSERT INTO games
(name, difficulty, description, price, picture, genre, year, rating)
VALUES
    (
        'Animal Crossing',
        1,
        'Partez à la découverte d''une forêt ancienne peuplée de créatures mystiques. Forgez des alliances, récoltez des ressources et repoussez les ombres qui envahissent l''île.',
        59.99,
        'jeux/animalcrossing.jpg',
        'RPG',
        2020,
        4.8
    ),
    (
        'Mario Kart',
        1,
        'Chevauche les vagues des îles tropicales dans ce jeu de surf aux décors colorés. Enchaîne les figures, débloques de nouvelles planches et affronte les champions locaux.',
        49.99,
        'jeux/mariokart.jpg',
        'Sport',
        2024,
        4.5
    ),
    (
        'Zelda Breath of the Wild',
        2,
        'Escalade les châteaux flottants de l''île de Numéa dans ce jeu de plateforme enchanteur. Des secrets se cachent derrière chaque nuage, des trésors t''attendent au sommet.',
        69.99,
        'jeux/zelda.jpg',
        'Aventure',
        2022,
        4.6
    ),
    (
        'Link''s Awakening',
        2,
        'Le vieux Tom Raton a caché des trésors aux quatre coins de l''île. Résous ses énigmes, déchiffre ses pictogrammes et retrouve les reliques perdues de l''archipel.',
        44.99,
        'jeux/link.jpg',
        'Puzzle',
        2023,
        4.9
    ),
    (
        'Ori and the Blind Forest',
        2,
        'Barre ton navire à travers le lagon bleu et affronte les redoutables Pirates du Crabe. Recrute un équipage, améliore ton bateau et trouve le mythique Trésor de Tom Nook.',
        39.99,
        'jeux/ori.jpg',
        'Aventure',
        2024,
        4.7
    ),
    (
        'Yoshi''s Crafted World',
        1,
        'Cultive le plus beau jardin de l''archipel en résolvant des casse-têtes floraux. Croise des espèces rares, arrange des massifs et déclenche la floraison des plantes légendaires.',
        34.99,
        'jeux/yoshi.jpg',
        'Plateforme',
        2022,
        4.4
    ),
    (
        'Mario Party',
        1,
        'Rejoins le groupe de K.K. Slider pour une tournée épique à travers toutes les îles ! Compose des mélodies, improvise en concert et deviens la légende musicale de l''archipel.',
        59.99,
        'jeux/marioparty.jpg',
        'Aventure',
        2024,
        4.8
    ),
    (
        'Pokemon Violet',
        2,
        'L''île volcanique de Kaimana est en danger ! Affronte les esprits de lave, réunis les cinq artefacts ancestraux et apaise le Volcan Suprême avant l''éruption finale.',
        59.99,
        'jeux/pokemonviolet.jpg',
        'RPG',
        2023,
        4.5
    );