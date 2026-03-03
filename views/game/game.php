<h1>Les jeux</h1>

<?php if (empty($games)): ?>
    <p>Aucun jeu disponible pour le moment.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Genre</th>
            <th>Année</th>
            <th>Note</th>
            <th>Difficulté</th>
            <th>Prix</th>
            <?php if (Auth::isLoggedIn()): ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($games as $game): ?>
            <tr>
                <td><?= htmlspecialchars($game['name']) ?></td>
                <td><?= htmlspecialchars($game['genre']) ?></td>
                <td><?= htmlspecialchars($game['year']) ?></td>
                <td><?= htmlspecialchars($game['rating']) ?></td>
                <td><?= htmlspecialchars($game['difficulty']) ?></td>
                <td><?= htmlspecialchars($game['price']) ?> €</td>
                <?php if (Auth::isLoggedIn()): ?>
                    <td>
                        <?php if (in_array($game['id'], $ownedGameIds)): ?>
                            <span>Déjà dans ma liste</span>
                        <?php else: ?>
                            <form method="POST" action="<?= BASE_URL ?>usergame.php">
                                <input type="hidden" name="action"  value="add">
                                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                <button type="submit">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>
<a href="<?= BASE_URL ?>profile.php">Mon profil</a>
