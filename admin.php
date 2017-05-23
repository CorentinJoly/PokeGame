<h2>Bienvenue Dresseur</h2>

<?php

if (!isset($_SESSION['auth'])) { ?>
	<div class="error">
		<p>Attention</p>
		<ul>
			<li>Pour accéder à cette page merci de vous authentifier</li>
		</ul>
	</div>
	<a href="./index.php?page=inscription"><button class="button">INSCRIPTION</button></a>
	<a href="./index.php?page=connexion"><button class="button">CONNEXION</button></a>

<?php } else { 
	
	//On récupère les données de l'utilisateur
	$user = $_SESSION['auth'];

} ?>
