CREATE TABLE IF NOT EXISTS users (
     id         INTEGER PRIMARY KEY AUTOINCREMENT,
     username   TEXT NOT NULL,
     email      TEXT UNIQUE NOT NULL,
     password   TEXT NOT NULL,
     role       TEXT DEFAULT 'villageois',
     banned     INTEGER DEFAULT 0,
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
     banned      INTEGER DEFAULT 0,
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
    icon        TEXT NOT NULL DEFAULT '🏆',
    game_id     INTEGER NOT NULL,
    description TEXT,
    UNIQUE(name, game_id),
    FOREIGN KEY (game_id) REFERENCES games(id)
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


/* ── JEUX ── */
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Animal Crossing', 1, 'Partez à la découverte d''une forêt ancienne peuplée de créatures mystiques. Forgez des alliances, récoltez des ressources et repoussez les ombres qui envahissent l''île.', 59.99, 'jeux/animalcrossing.jpg', 'RPG', 2020, 4.8 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Animal Crossing');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Mario Kart', 1, 'Chevauche les vagues des îles tropicales dans ce jeu de surf aux décors colorés. Enchaîne les figures, débloques de nouvelles planches et affronte les champions locaux.', 49.99, 'jeux/mariokart.jpg', 'Sport', 2024, 4.5 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Mario Kart');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Zelda Breath of the Wild', 2, 'Escalade les châteaux flottants de l''île de Numéa dans ce jeu de plateforme enchanteur. Des secrets se cachent derrière chaque nuage, des trésors t''attendent au sommet.', 69.99, 'jeux/zelda.jpg', 'Aventure', 2022, 4.6 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Zelda Breath of the Wild');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Link''s Awakening', 2, 'Le vieux Tom Raton a caché des trésors aux quatre coins de l''île. Résous ses énigmes, déchiffre ses pictogrammes et retrouve les reliques perdues de l''archipel.', 44.99, 'jeux/link.jpg', 'Puzzle', 2023, 4.9 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Link''s Awakening');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Ori and the Blind Forest', 2, 'Barre ton navire à travers le lagon bleu et affronte les redoutables Pirates du Crabe. Recrute un équipage, améliore ton bateau et trouve le mythique Trésor de Tom Nook.', 39.99, 'jeux/ori.jpg', 'Aventure', 2024, 4.7 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Ori and the Blind Forest');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Yoshi''s Crafted World', 1, 'Cultive le plus beau jardin de l''archipel en résolvant des casse-têtes floraux. Croise des espèces rares, arrange des massifs et déclenche la floraison des plantes légendaires.', 34.99, 'jeux/yoshi.jpg', 'Plateforme', 2022, 4.4 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Yoshi''s Crafted World');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Mario Party', 1, 'Rejoins le groupe de K.K. Slider pour une tournée épique à travers toutes les îles ! Compose des mélodies, improvise en concert et deviens la légende musicale de l''archipel.', 59.99, 'jeux/marioparty.jpg', 'Aventure', 2024, 4.8 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Mario Party');
INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating) SELECT 'Pokemon Violet', 2, 'L''île volcanique de Kaimana est en danger ! Affronte les esprits de lave, réunis les cinq artefacts ancestraux et apaise le Volcan Suprême avant l''éruption finale.', 59.99, 'jeux/pokemonviolet.jpg', 'RPG', 2023, 4.5 WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Pokemon Violet');

/* ── TROPHÉES ── */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Premier Pas',           '🌱', id, 'Poser le pied sur l''île pour la première fois' FROM games WHERE name = 'Animal Crossing';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Cueilleur Pro',          '🍄', id, 'Récolter 100 ressources naturelles'             FROM games WHERE name = 'Animal Crossing';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Ami des Bêtes',          '🦌', id, 'Se lier d''amitié avec toutes les créatures'     FROM games WHERE name = 'Animal Crossing';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Magie Verte',            '✨', id, 'Découvrir tous les secrets de la forêt'          FROM games WHERE name = 'Animal Crossing';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'First Ride',             '🏄', id, 'Terminer ta première course'                     FROM games WHERE name = 'Mario Kart';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Surfeur de l''île',      '🌊', id, 'Gagner 10 courses consécutives'                  FROM games WHERE name = 'Mario Kart';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Champion Tropical',      '🏆', id, 'Remporter le championnat toutes catégories'      FROM games WHERE name = 'Mario Kart';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Tête dans les Nuages',  '☁️', id, 'Atteindre le château flottant le plus haut'      FROM games WHERE name = 'Zelda Breath of the Wild';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Collectionneur Étoiles','⭐', id, 'Collecter toutes les étoiles cachées'            FROM games WHERE name = 'Zelda Breath of the Wild';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Maître des Clés',       '🔑', id, 'Ouvrir toutes les portes secrètes'               FROM games WHERE name = 'Zelda Breath of the Wild';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Roi du Château',        '👑', id, 'Vaincre le Seigneur des Orages'                  FROM games WHERE name = 'Zelda Breath of the Wild';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Détective en Herbe',    '🔎', id, 'Résoudre les 5 premières énigmes'                FROM games WHERE name = 'Link''s Awakening';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Flash Inspiration',     '💡', id, 'Trouver une solution en moins de 30 secondes'    FROM games WHERE name = 'Link''s Awakening';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Garde-Clé',             '🗝️', id, 'Collecter toutes les clés de l''île'              FROM games WHERE name = 'Link''s Awakening';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Premier Mousse',        '⚓', id, 'Embarquer pour la première fois'                 FROM games WHERE name = 'Ori and the Blind Forest';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Ami du Perroquet',      '🦜', id, 'Apprivoiser le perroquet de bord'                FROM games WHERE name = 'Ori and the Blind Forest';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Richesse des Mers',     '💰', id, 'Accumuler 10 000 pièces de butin'                FROM games WHERE name = 'Ori and the Blind Forest';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Cartographe',           '🗺️', id, 'Cartographier toutes les îles'                    FROM games WHERE name = 'Ori and the Blind Forest';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Capitaine',             '🏴', id, 'Vaincre le pirate légendaire'                    FROM games WHERE name = 'Ori and the Blind Forest';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Main Verte',            '🌸', id, 'Faire fleurir ta première plante'                FROM games WHERE name = 'Yoshi''s Crafted World';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Fleuriste Expert',      '🌺', id, 'Cultiver toutes les espèces rares'               FROM games WHERE name = 'Yoshi''s Crafted World';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Première Corde',        '🎸', id, 'Jouer ta première mélodie'                       FROM games WHERE name = 'Mario Party';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Compositeur',           '🎵', id, 'Composer 5 mélodies originales'                  FROM games WHERE name = 'Mario Party';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Rock Star Insulaire',   '⭐', id, 'Remplir la grande scène'                         FROM games WHERE name = 'Mario Party';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Voix de l''Île',        '🎤', id, 'Être élu meilleur artiste de l''archipel'         FROM games WHERE name = 'Mario Party';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Ignifugé',              '🔥', id, 'Survivre à une éruption volcanique'              FROM games WHERE name = 'Pokemon Violet';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Dompte-Volcan',         '🌋', id, 'Apaiser le Volcan Suprême'                       FROM games WHERE name = 'Pokemon Violet';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Cristal de Lave',       '💎', id, 'Trouver le cristal légendaire'                   FROM games WHERE name = 'Pokemon Violet';
INSERT OR IGNORE INTO trophies (name, icon, game_id, description) SELECT 'Survivant',             '🧨', id, 'Finir le jeu sans perdre une vie'                FROM games WHERE name = 'Pokemon Violet';
