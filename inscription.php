<?php
if (isset($_SESSION['auth']))
	createFlashMessage('success', 'Vous êtes déjà connecté', 'home');
?>
<h2>Inscription</h2>

<form method="POST" action="index.php">
<input type="hidden" name="action" value="inscription">

	<div class="container">
		<label><b>Nom d'utilisateur</b></label>
		<input type="text" placeholder="Nom d'utilisateur" name="username" required>

		<label><b>Email</b></label>
		<input type="email" placeholder="Adresse email" name="mail" required>

		<label><b>Mot de passe</b></label>
		<input type="password" placeholder="Entrer Mot de passe" name="password" required>

		<label><b>Mot de passe</b></label>
		<input type="password" placeholder="Entrer Mot de passe" name="password-confirm" required>

		<label><b>Mon Pokémon de départ</b></label>
		<div style="display: flex; flex-direction: row; justify-content: space-around; align-items: stretch;">
			<input type="radio" name="idPokemon" value="001" checked>
			<label for="bulbizarre"><img src="images/Bulbizarre.jpg" alt="bulbizarre" width="100px" height="100px"></label>

			<input type="radio" name="idPokemon" value="004">
			<label for="salameche"><img src="images/Salameche.jpg" alt="salameche" width="100px" height="100px"></label>	

			<input type="radio" name="idPokemon" value="007">
			<label for="carapuce"><img src="images/Carapuce.jpg" alt="carapuce" width="100px" height="100px"></label>	
		</div>

		<br>
		<div class="g-recaptcha" data-sitekey="6LcBHg4TAAAAAKGg5ciNvfXYhBDh5iKvFB5GP4zG" re></div>

		<button type="submit">S'inscrire</button>
	</div>

</form>