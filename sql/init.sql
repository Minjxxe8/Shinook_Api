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
     difficulty  INTEGER DEFAULT '1',
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