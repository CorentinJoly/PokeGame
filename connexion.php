<?php
if (isset($_SESSION['auth']))
	createFlashMessage('success', 'Vous êtes déjà connecté', 'home');
?>

<h2>Connexion</h2>

<form method="POST" action="index.php">
<input type="hidden" name="action" value="connexion">

	<div class="container">
		<label><b>Nom d'utilisateur ou email</b></label>
		<input type="text" placeholder="Nom d'utilisateur" name="username" required>

		<label><b>Mot de passe</b></label>
		<input type="password" placeholder="Entrer Mot de passe" name="password" required>

		<button type="submit">Se connecter</button>
	</div>

</form>