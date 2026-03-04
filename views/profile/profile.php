<?php Auth::requireLogin(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shinook – Mon Profil</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/profile.css">
</head>
<body>

<div class="leaf-bg" id="leafBg"></div>

<nav>
    <a href="<?= BASE_URL ?>game.php" class="nav-logo">
        <img src="icons/Shinook.png" alt="Shinook" class="logo">
        Shinook
    </a>
    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>game.php">Accueil</a></li>
        <li><a href="<?= BASE_URL ?>profile.php" class="active">Profil</a></li>
        <li><a href="<?= BASE_URL ?>logout.php" class="btn-nav">Se déconnecter</a></li>
    </ul>
</nav>

<div class="page-wrap">
    <div id="profileView" style="display:block;">
        <div class="profile-banner">
            <div class="profile-avatar">🦝</div>
            <div class="profile-info">
                <div class="p-name"><?= htmlspecialchars($user['username']) ?></div>
                <div class="p-role">🌿 <?= htmlspecialchars($user['role']) ?></div>
            </div>
            <div class="profile-stats">
                <div class="p-stat"><div class="sv"><?= count($games) ?></div><div class="sl">Jeux</div></div>
                <div class="p-stat"><div class="sv"><?= htmlspecialchars((string)$user['created_at']) ?></div><div class="sl">Membre depuis</div></div>
            </div>
            <!-- <a href="<?= BASE_URL ?>logout.php" class="logout-btn" style="text-decoration:none;display:inline-flex;align-items:center;">Quitter l'île</a> -->
        </div>

        <div class="section-header">
            <div class="section-title">🎮 Ma bibliothèque</div>
            <a href="<?= BASE_URL ?>game.php" style="padding:0.5rem 1.2rem;background:var(--green);color:white;border-radius:50px;text-decoration:none;font-weight:800;font-size:0.85rem;box-shadow:0 3px 0 var(--green-dark);">+ Ajouter des jeux</a>
        </div>

        <div class="library-grid">
            <?php if (empty($games)): ?>
                <div class="empty-lib">
                    <span class="e-emoji">🏝️</span>
                    <h3>Ta bibliothèque est vide !</h3>
                    <p>Explore l'accueil et ajoute des jeux à ta collection.</p>
                    <a href="<?= BASE_URL ?>game.php">Découvrir les jeux →</a>
                </div>
            <?php else: ?>
                <?php foreach ($games as $game): ?>
                    <div class="lib-card">
                        <div class="lib-card-top">
                            <div class="lib-emoji">🎮</div>
                            <div class="lib-info">
                                <div class="lib-title"><?= htmlspecialchars($game['name']) ?></div>
                                <div class="lib-genre"><?= htmlspecialchars((string)$game['year']) ?></div>
                            </div>
                        </div>

                        <div class="lib-card-meta">
                            <div class="lib-meta-item"><div class="mv"><?= htmlspecialchars(number_format((float)$game['rating'], 1)) ?></div><div class="ml">Note</div></div>
                            <div class="lib-meta-item"><div class="mv"><?= htmlspecialchars(number_format((float)$game['price'], 2)) ?>€</div><div class="ml">Prix</div></div>
                            <div class="lib-meta-item"><div class="mv"><?= htmlspecialchars((string)$game['difficulty']) ?></div><div class="ml">Difficulté</div></div>
                        </div>

                        <div class="lib-actions">
                            <form method="POST" action="<?= BASE_URL ?>usergame.php" style="display:flex;flex:1;">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="game_id" value="<?= (int)$game['game_id'] ?>">
                                <input type="hidden" name="redirect" value="profile.php">
                                <button type="submit" class="lib-btn lib-btn-del">🗑️ Retirer</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="section-header" style="margin-top:0.5rem;">
            <div class="section-title">🏆 Mes trophées</div>
        </div>

        <div class="auth-card" style="max-width:700px;margin:0 auto 3rem;display:flex;justify-content:center;">
            <div class="p-stat" style="min-width:unset;">
                <div class="sv"><?= (int)$totalTrophies ?></div>
                <div class="sl">Trophées total</div>
            </div>
        </div>

        <div class="auth-card" style="max-width:700px;margin:0 auto;">
            <div class="auth-card-title">✏️ Modifier mon profil</div>

            <?php if (!empty($errors)): ?>
                <div style="margin-bottom:1rem;color:#c0392b;font-weight:700;">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>profile.php">
                <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Nouveau mot de passe (optionnel)</label>
                    <input type="password" name="new_password">
                </div>
                <div class="form-group">
                    <label>Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password">
                </div>
                <button type="submit" class="btn-full">Mettre à jour</button>
            </form>

            <a href="<?= BASE_URL ?>delete.php" class="btn-full" style="margin-top:0.8rem;background:#c0392b;box-shadow:0 4px 0 #922b21;text-decoration:none;display:flex;justify-content:center;">Supprimer mon compte</a>
        </div>
    </div>
</div>

<footer>
    <strong>Shinook</strong> — Fait par Elisabeth ROBL, Léna Ricard et Emma De Oliveira &nbsp;|&nbsp; Tom Nook vous surveille 🦝
</footer>

<script src="js/stickers.js"></script>
<script>
initFloatingStickers({ count: 15 });
</script>
</body>
</html>