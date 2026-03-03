<?php Auth::requireLogin(); ?>

<h1>Mon profil</h1>

<p><strong>Nom :</strong> <?= htmlspecialchars($user['username']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></p>
<p><strong>Membre depuis :</strong> <?= htmlspecialchars($user['created_at']) ?></p>

<br>
<hr>
<h2>Modifier mon profil</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>profile.php">
    <label>Nom d'utilisateur</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

    <label>Mot de passe actuel (obligatoire)</label><br>
    <input type="password" name="password" required><br><br>

    <label>Nouveau mot de passe (optionnel)</label><br>
    <input type="password" name="new_password"><br><br>

    <label>Confirmer le nouveau mot de passe</label><br>
    <input type="password" name="confirm_password"><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<br>
<hr>
<h2>Mes jeux</h2>

<?php if (empty($games)): ?>
    <p>Aucun jeu dans ta liste.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Genre</th>
            <th>Année</th>
            <th>Prix</th>
            <th>Ajouté le</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($games as $game): ?>
            <tr>
                <td><?= htmlspecialchars($game['name']) ?></td>
                <td><?= htmlspecialchars($game['genre']) ?></td>
                <td><?= htmlspecialchars($game['year']) ?></td>
                <td><?= htmlspecialchars($game['price']) ?> €</td>
                <td><?= htmlspecialchars($game['purchase_at']) ?></td>
                <td>
                    <form method="POST" action="<?= BASE_URL ?>usergame.php">
                        <input type="hidden" name="action"  value="remove">
                        <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                        <button type="submit">Retirer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>
<a href="<?= BASE_URL ?>game.php">Voir tous les jeux</a> |
<a href="<?= BASE_URL ?>logout.php">Se déconnecter</a> |
<a href="<?= BASE_URL ?>delete.php">Supprimer mon compte</a>