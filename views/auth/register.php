<?php if (!empty($errors)): ?>
    <p><?= $errors[0] ?></p>
<?php endif; ?>

<!-- Le formulaire qui envoie vers register.php en POST -->
<form method="POST" action="register.php">
    <input type="text"     name="username"    placeholder="Nom d'utilisateur">
    <input type="email"    name="email"       placeholder="Email">
    <input type="password" name="password"    placeholder="Mot de passe">
    <input type="password" name="confirm"     placeholder="Confirmer le mot de passe">
    <button>S'inscrire</button>
</form>