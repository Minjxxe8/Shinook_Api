# 🏝️ Shinook — Bibliothèque de jeux

> *Ta biblio de jeux, style Deserted Island* ✨

Shinook est une application web PHP inspirée de l'univers d'Animal Crossing permettant de gérer une bibliothèque de jeux vidéo. Les utilisateurs peuvent parcourir un catalogue, ajouter des jeux à leur collection personnelle, collecter des trophées et personnaliser leur profil.

---

## Aperçu

| Page d'accueil | Profil |
|:-:|:-:|
| Catalogue de jeux avec filtres et recherche | Bibliothèque personnelle, trophées et admin |

---

## Installation

### Prérequis

- **PHP 8.1+** (avec extension `pdo_sqlite` activée)
- Un navigateur web moderne

### Lancement

1. **Cloner** ou télécharger le projet.

2. **Démarrer** le serveur PHP intégré depuis le dossier `public/` :

   ```bash
   cd Shinook_Api/public
   php -S localhost:8000
   ```

3. **Ouvrir** le navigateur à l'adresse :

   ```
   http://localhost:8000/
   ```

> ⚠️ Le serveur **doit** être lancé depuis `Shinook_Api/public/` pour que les chemins fonctionnent correctement.

La base de données SQLite est créée automatiquement au premier lancement avec les jeux et trophées pré-remplis.

---

## Fonctionnalités

### Visiteur (non connecté)
- Parcourir le catalogue de jeux
- Filtrer par genre et rechercher par nom
- Consulter les détails d'un jeu (note, année, prix, description)

### Utilisateur connecté (Villageois)
- **Inscription / Connexion / Déconnexion**
- **Bibliothèque personnelle** — Ajouter ou retirer des jeux
- **Trophées** — Cocher / décocher les trophées obtenus pour chaque jeu de sa bibliothèque
- **Profil** — Modifier son nom d'utilisateur, email et mot de passe
- **Suppression de compte**

### Administrateur (Team Nook)
- **Panneau d'administration** sur la page profil
- **Gestion des utilisateurs** — Bannir / débannir des comptes
- **Gestion des jeux** — Bannir / restaurer des jeux du catalogue

---

## Architecture du projet

```
Shinook_Api/
├── config/
│   └── config.php            # Configuration (BASE_URL, sessions, rôles)
├── controllers/
│   ├── AuthController.php     # Inscription, connexion, déconnexion, suppression
│   ├── GameController.php     # Affichage du catalogue
│   ├── ProfileController.php  # Profil, mise à jour, admin
│   └── UserGameController.php # Ajout / retrait de jeux
├── core/
│   ├── Auth.php               # Gestion de l'authentification et des sessions
│   ├── Database.php           # Singleton PDO (SQLite)
│   └── Model.php              # Classe abstraite CRUD de base
├── models/
│   ├── GameModel.php          # Requêtes liées aux jeux
│   ├── ProfileModel.php       # Requêtes liées aux utilisateurs
│   ├── TrophyModel.php        # Requêtes liées aux trophées
│   └── UserGameModel.php      # Requêtes liées à la bibliothèque utilisateur
├── public/                    # ← Point d'entrée du serveur web
│   ├── index.php              # Redirection vers game.php
│   ├── game.php               # Page catalogue
│   ├── login.php              # Page connexion
│   ├── register.php           # Page inscription
│   ├── profile.php            # Page profil
│   ├── trophy.php             # Toggle des trophées (POST)
│   ├── usergame.php           # Ajout/retrait de jeux (POST)
│   ├── logout.php             # Page déconnexion
│   ├── delete.php             # Page suppression de compte
│   ├── css/                   # Feuilles de style
│   ├── js/                    # Scripts JS (stickers flottants)
│   ├── icons/                 # Icônes et logo
│   ├── jeux/                  # Images des jeux
│   └── stickers/              # Stickers décoratifs
├── sql/
│   ├── init.sql               # Schéma + données initiales (jeux, trophées)
│   └── database.sqlite        # Base de données (générée automatiquement)
└── views/
    ├── auth/
    │   ├── login.php           # Vue connexion
    │   ├── register.php        # Vue inscription
    │   ├── logout.php          # Vue déconnexion
    │   └── delete.php          # Vue suppression de compte
    ├── game/
    │   └── game.php            # Vue catalogue de jeux
    └── profile/
        └── profile.php         # Vue profil + admin
```

---

## Base de données

SQLite avec les tables suivantes :

| Table | Description |
|---|---|
| `users` | Comptes utilisateurs (username, email, password, rôle, statut banni) |
| `games` | Catalogue de jeux (nom, genre, année, note, prix, description, image) |
| `levels` | Niveaux associés aux jeux |
| `trophies` | Trophées associés aux jeux (nom, icône, description) |
| `users_game` | Bibliothèque personnelle (association utilisateur ↔ jeu) |
| `users_levels` | Progression des niveaux par utilisateur |
| `users_trophies` | Trophées obtenus par chaque utilisateur |

---

## Stack technique

- **Back-end** — PHP 8.1+ (POO, architecture MVC)
- **Base de données** — SQLite 3 via PDO
- **Front-end** — HTML5, CSS3 (variables CSS, grid, flexbox, animations), JavaScript vanilla
- **Polices** — Nunito + Fredoka One (Google Fonts)
- **Design** — Thème Animal Crossing (couleurs pastel, stickers flottants, emojis)

---

## Rôles

| Rôle | Valeur en base | Permissions |
|---|---|---|
| Villageois | `villageois` | Catalogue, bibliothèque, trophées, profil |
| Team Nook | `Team Nook` | Tout + panneau admin (bannir users/jeux) |

---

## Jeux inclus par défaut

| Jeu | Genre | Trophées |
|---|---|---|
| Animal Crossing | RPG | 4 |
| Mario Kart | Sport | 3 |
| Zelda Breath of the Wild | Aventure | 4 |
| Link's Awakening | Puzzle | 3 |
| Ori and the Blind Forest | Aventure | 5 |
| Yoshi's Crafted World | Plateforme | 2 |
| Mario Party | Aventure | 4 |
| Pokemon Violet | RPG | 4 |

---

Projet réalisé par **Elisabeth ROBL**, **Léna Ricard** et **Emma De Oliveira**.

