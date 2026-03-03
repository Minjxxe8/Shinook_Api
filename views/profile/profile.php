<?php Auth::requireLogin(); ?>

<h1>Mon profil</h1>

<p><strong>Nom :</strong> <?= htmlspecialchars($user['username']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></p>
<p><strong>Membre depuis :</strong> <?= htmlspecialchars($user['created_at']) ?></p>

<br>
<a href="<?= BASE_URL ?>logout.php">Se déconnecter</a> |
<a href="<?= BASE_URL ?>delete.php">Supprimer mon compte</a> |
<a href="<?= BASE_URL ?>game.php">Les jeux</a>