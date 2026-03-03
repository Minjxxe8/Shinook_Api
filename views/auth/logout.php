<?php Auth::requireLogin(); ?>

<h1>Déconnexion</h1>

<p>Êtes-vous sûr de vouloir vous déconnecter, <?= htmlspecialchars(Auth::currentUser()['username']) ?> ?</p>

<form method="POST" action="<?= BASE_URL ?>logout.php">
    <button type="submit">Se déconnecter</button>
</form>

<br>
<a href="<?= BASE_URL ?>profile.php">Annuler</a>