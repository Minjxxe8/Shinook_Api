<?php Auth::requireLogin(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shinook – Supprimer le compte</title>
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
        <li><a href="<?= BASE_URL ?>profile.php">Profil</a></li>
        <li><a href="<?= BASE_URL ?>delete.php" class="active">Supprimer</a></li>
    </ul>
</nav>

<div class="page-wrap">
    <div class="auth-header">
        <img src="icons/profil.jpg" alt="Profil" class="welcome-emoji">
        <h1>Supprimer mon compte</h1>
        <p>Action irréversible : confirme tes identifiants pour continuer.</p>
    </div>

    <div class="auth-container" style="grid-template-columns:minmax(280px,560px);justify-content:center;">
        <div class="auth-card">
            <div class="auth-card-title">⚠️ Zone sensible</div>

            <?php if (!empty($errors)): ?>
                <div style="margin-bottom:1rem;color:#c0392b;font-weight:700;">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>delete.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-full" style="background:#c0392b;box-shadow:0 4px 0 #922b21;">Supprimer définitivement mon compte</button>
            </form>

            <a href="<?= BASE_URL ?>profile.php" class="btn-full" style="display:flex;justify-content:center;align-items:center;text-decoration:none;margin-top:0.8rem;">Annuler</a>
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
