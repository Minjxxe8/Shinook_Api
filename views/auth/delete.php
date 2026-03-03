<?php Auth::requireLogin(); ?>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h1>Supprimer mon compte</h1>

<p>Cette action est irréversible. Confirmez votre mot de passe pour supprimer définitivement votre compte.</p>

<form method="POST" action="<?= BASE_URL ?>delete.php">

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Supprimer mon compte</button>
</form>

<br>
<a href="<?= BASE_URL ?>profile.php">Annuler</a>
