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
    icon        TEXT NOT NULL DEFAULT '🏆',
    game_id     INTEGER NOT NULL,
    description TEXT,
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

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Animal Crossing', 1, 'Partez à la découverte d''une forêt ancienne peuplée de créatures mystiques. Forgez des alliances, récoltez des ressources et repoussez les ombres qui envahissent l''île.', 59.99, 'jeux/animalcrossing.jpg', 'RPG', 2020, 4.8
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Animal Crossing');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Mario Kart', 1, 'Chevauche les vagues des îles tropicales dans ce jeu de surf aux décors colorés. Enchaîne les figures, débloques de nouvelles planches et affronte les champions locaux.', 49.99, 'jeux/mariokart.jpg', 'Sport', 2024, 4.5
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Mario Kart');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Zelda Breath of the Wild', 2, 'Escalade les châteaux flottants de l''île de Numéa dans ce jeu de plateforme enchanteur. Des secrets se cachent derrière chaque nuage, des trésors t''attendent au sommet.', 69.99, 'jeux/zelda.jpg', 'Aventure', 2022, 4.6
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Zelda Breath of the Wild');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Link''s Awakening', 2, 'Le vieux Tom Raton a caché des trésors aux quatre coins de l''île. Résous ses énigmes, déchiffre ses pictogrammes et retrouve les reliques perdues de l''archipel.', 44.99, 'jeux/link.jpg', 'Puzzle', 2023, 4.9
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Link''s Awakening');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Ori and the Blind Forest', 2, 'Barre ton navire à travers le lagon bleu et affronte les redoutables Pirates du Crabe. Recrute un équipage, améliore ton bateau et trouve le mythique Trésor de Tom Nook.', 39.99, 'jeux/ori.jpg', 'Aventure', 2024, 4.7
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Ori and the Blind Forest');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Yoshi''s Crafted World', 1, 'Cultive le plus beau jardin de l''archipel en résolvant des casse-têtes floraux. Croise des espèces rares, arrange des massifs et déclenche la floraison des plantes légendaires.', 34.99, 'jeux/yoshi.jpg', 'Plateforme', 2022, 4.4
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Yoshi''s Crafted World');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Mario Party', 1, 'Rejoins le groupe de K.K. Slider pour une tournée épique à travers toutes les îles ! Compose des mélodies, improvise en concert et deviens la légende musicale de l''archipel.', 59.99, 'jeux/marioparty.jpg', 'Aventure', 2024, 4.8
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Mario Party');

INSERT OR IGNORE INTO games (name, difficulty, description, price, picture, genre, year, rating)
SELECT 'Pokemon Violet', 2, 'L''île volcanique de Kaimana est en danger ! Affronte les esprits de lave, réunis les cinq artefacts ancestraux et apaise le Volcan Suprême avant l''éruption finale.', 59.99, 'jeux/pokemonviolet.jpg', 'RPG', 2023, 4.5
WHERE NOT EXISTS (SELECT 1 FROM games WHERE name = 'Pokemon Violet');

/* ── TROPHÉES ── */

/* Animal Crossing */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🌱 Premier Pas', '🌱', g.id, 'Poser le pied sur l''île pour la première fois'
FROM games g WHERE g.name = 'Animal Crossing'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🌱 Premier Pas' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🍄 Cueilleur Pro', '🍄', g.id, 'Récolter 100 ressources naturelles'
FROM games g WHERE g.name = 'Animal Crossing'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🍄 Cueilleur Pro' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🦌 Ami des Bêtes', '🦌', g.id, 'Se lier d''amitié avec toutes les créatures de l''île'
FROM games g WHERE g.name = 'Animal Crossing'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🦌 Ami des Bêtes' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '✨ Magie Verte', '✨', g.id, 'Découvrir tous les secrets de la forêt'
FROM games g WHERE g.name = 'Animal Crossing'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '✨ Magie Verte' AND t.game_id = g.id);

/* Mario Kart */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🏄 First Ride', '🏄', g.id, 'Terminer ta première course'
FROM games g WHERE g.name = 'Mario Kart'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🏄 First Ride' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🌊 Surfeur de l''île', '🌊', g.id, 'Gagner 10 courses consécutives'
FROM games g WHERE g.name = 'Mario Kart'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🌊 Surfeur de l''île' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🏆 Champion Tropical', '🏆', g.id, 'Remporter le championnat toutes catégories'
FROM games g WHERE g.name = 'Mario Kart'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🏆 Champion Tropical' AND t.game_id = g.id);

/* Zelda Breath of the Wild */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '☁️ Tête dans les Nuages', '☁️', g.id, 'Atteindre le château flottant le plus haut'
FROM games g WHERE g.name = 'Zelda Breath of the Wild'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '☁️ Tête dans les Nuages' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '⭐ Collectionneur d''Étoiles', '⭐', g.id, 'Collecter toutes les étoiles cachées'
FROM games g WHERE g.name = 'Zelda Breath of the Wild'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '⭐ Collectionneur d''Étoiles' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🔑 Maître des Clés', '🔑', g.id, 'Ouvrir toutes les portes secrètes'
FROM games g WHERE g.name = 'Zelda Breath of the Wild'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🔑 Maître des Clés' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '👑 Roi du Château', '👑', g.id, 'Vaincre le Seigneur des Orages'
FROM games g WHERE g.name = 'Zelda Breath of the Wild'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '👑 Roi du Château' AND t.game_id = g.id);

/* Link's Awakening */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🔎 Détective en Herbe', '🔎', g.id, 'Résoudre les 5 premières énigmes'
FROM games g WHERE g.name = 'Link''s Awakening'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🔎 Détective en Herbe' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '💡 Flash d''Inspiration', '💡', g.id, 'Trouver une solution en moins de 30 secondes'
FROM games g WHERE g.name = 'Link''s Awakening'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '💡 Flash d''Inspiration' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🗝️ Garde-Clé', '🗝️', g.id, 'Collecter toutes les clés de l''île'
FROM games g WHERE g.name = 'Link''s Awakening'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🗝️ Garde-Clé' AND t.game_id = g.id);

/* Ori and the Blind Forest */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '⚓ Premier Mousse', '⚓', g.id, 'Embarquer pour la première fois'
FROM games g WHERE g.name = 'Ori and the Blind Forest'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '⚓ Premier Mousse' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🦜 Ami du Perroquet', '🦜', g.id, 'Apprivoiser le perroquet de bord'
FROM games g WHERE g.name = 'Ori and the Blind Forest'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🦜 Ami du Perroquet' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '💰 Richesse des Mers', '💰', g.id, 'Accumuler 10 000 pièces de butin'
FROM games g WHERE g.name = 'Ori and the Blind Forest'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '💰 Richesse des Mers' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🗺️ Cartographe', '🗺️', g.id, 'Cartographier toutes les îles'
FROM games g WHERE g.name = 'Ori and the Blind Forest'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🗺️ Cartographe' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🏴‍☠️ Capitaine', '🏴‍☠️', g.id, 'Vaincre le pirate légendaire'
FROM games g WHERE g.name = 'Ori and the Blind Forest'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🏴‍☠️ Capitaine' AND t.game_id = g.id);

/* Yoshi's Crafted World */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🌸 Main Verte', '🌸', g.id, 'Faire fleurir ta première plante'
FROM games g WHERE g.name = 'Yoshi''s Crafted World'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🌸 Main Verte' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🌺 Fleuriste Expert', '🌺', g.id, 'Cultiver toutes les espèces rares'
FROM games g WHERE g.name = 'Yoshi''s Crafted World'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🌺 Fleuriste Expert' AND t.game_id = g.id);

/* Mario Party */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🎸 Première Corde', '🎸', g.id, 'Jouer ta première mélodie'
FROM games g WHERE g.name = 'Mario Party'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🎸 Première Corde' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🎵 Compositeur', '🎵', g.id, 'Composer 5 mélodies originales'
FROM games g WHERE g.name = 'Mario Party'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🎵 Compositeur' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '⭐ Rock Star Insulaire', '⭐', g.id, 'Remplir la grande scène'
FROM games g WHERE g.name = 'Mario Party'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '⭐ Rock Star Insulaire' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🎤 Voix de l''Île', '🎤', g.id, 'Être élu meilleur artiste de l''archipel'
FROM games g WHERE g.name = 'Mario Party'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🎤 Voix de l''Île' AND t.game_id = g.id);

/* Pokemon Violet */
INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🔥 Ignifugé', '🔥', g.id, 'Survivre à une éruption volcanique'
FROM games g WHERE g.name = 'Pokemon Violet'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🔥 Ignifugé' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🌋 Dompte-Volcan', '🌋', g.id, 'Apaiser le Volcan Suprême'
FROM games g WHERE g.name = 'Pokemon Violet'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🌋 Dompte-Volcan' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '💎 Cristal de Lave', '💎', g.id, 'Trouver le cristal légendaire'
FROM games g WHERE g.name = 'Pokemon Violet'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '💎 Cristal de Lave' AND t.game_id = g.id);

INSERT OR IGNORE INTO trophies (name, icon, game_id, description)
SELECT '🧨 Survivant', '🧨', g.id, 'Finir le jeu sans perdre une vie'
FROM games g WHERE g.name = 'Pokemon Violet'
AND NOT EXISTS (SELECT 1 FROM trophies t WHERE t.name = '🧨 Survivant' AND t.game_id = g.id);

