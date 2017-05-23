<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if (!isset($_SESSION['pokemon'])) {
	$pokemon = $_SESSION['pokemon'] = [];
}
?>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/style.css">
	<title>Pokémon</title>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
</head>
<header>

	<!-- NAVIGATION -->
<div class="navigation">
<span class="navigation__logo"><a href="./index.php?page=pokemons">PokéGame</a></span>
	<nav class="navigation__menu">
		<!-- Il faut laisser cette ligne sinon ça fou la merde, je sais pas pk -->
		<a></a>
		<ul style="list-style: none;">
		<?php if (isset($_SESSION['auth'])) { ?>
			<li><a href="./index.php?page=new">Nouvelle capture</a></li>
			<li><a href="./index.php?page=annonces">Annonces</a></li>
			<li><a href="./index.php?page=deconnexion">Déconnexion</a></li>
		<?php } ?>
		</ul>
	</nav>
</div>

<div class="separateur"></div>

</header>

<body>
	<container>

<?php
if (isset($_SESSION['flash'])) { ?>
	<?php foreach ($_SESSION['flash'] as $type => $message) { ?>
		<div class="alert alert-<?= $type; ?>">
			<?= $message; ?> 
		</div>
<?php }
unset($_SESSION['flash']);
} ?>