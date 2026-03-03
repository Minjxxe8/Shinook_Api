<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h1>Connexion</h1>

<form method="POST" action="<?= BASE_URL ?>login.php">
    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<br>
<a href="<?= BASE_URL ?>register.php">Pas encore de compte ? S'inscrire</a>