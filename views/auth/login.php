<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shinook – Connexion</title>
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
        <li><a href="<?= BASE_URL ?>login.php" class="active">Connexion</a></li>
        <li><a href="<?= BASE_URL ?>register.php" class="btn-nav">Créer un compte</a></li>
    </ul>
</nav>

<div class="page-wrap">
    <div class="auth-header">
        <img src="icons/profil.jpg" alt="Profil" class="welcome-emoji">
        <h1>Bon retour sur l'île !</h1>
        <p>Connecte-toi pour retrouver ta bibliothèque de jeux.</p>
    </div>

    <div class="auth-container" style="grid-template-columns:minmax(280px,520px);justify-content:center;">
        <div class="auth-card">
            <div class="auth-card-title">🔐 Se connecter</div>

            <?php if (!empty($errors)): ?>
                <div style="margin-bottom:1rem;color:#c0392b;font-weight:700;">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>login.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-full">Atterrir sur l'île</button>
            </form>

            <div class="form-divider">ou</div>
            <a href="<?= BASE_URL ?>register.php" class="btn-full" style="display:flex;justify-content:center;align-items:center;text-decoration:none;background:var(--brown);box-shadow:0 4px 0 #5c3d28;">Créer un compte</a>
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
