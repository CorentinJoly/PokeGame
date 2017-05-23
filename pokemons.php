<?php 
if (!isset($_SESSION['auth'])) { ?>

	<h2>Authentification nécessaire</h2>
	<a href="./index.php?page=inscription"><button class="button">INSCRIPTION</button></a>
	<a href="./index.php?page=connexion"><button class="button">CONNEXION</button></a>

<?php } 
else { 
//On récupère les données de l'utilisateur
$user = $_SESSION['auth']; 
?>

<h2>Dresseur <?= $user->nomDress ?></h2>

<!-- On récupère le nb de pokémon de l'utilisateur -->

<?php $nombre = getNbPokemonDresseur($user->idDresseur); ?>

Vous avez <?= $nombre->nbPokemon ?>
<?php
if ($nombre->nbPokemon <= 1) 
	echo " pokémon";
else
	echo " pokémons";
?>

<table style="margin-top: 80px;"> 
	<tr>
		<th width="40px"></th>
		<th>Sexe</th>
		<th>Espèce</th>
		<th>Description</th>
	</tr>

	<?php
	$reponses = getListPokemon($user->idDresseur);

	foreach($reponses as $valeur) { ?>

	<tr>
		<td style="text-align: center;"><a href="./index.php?page=detail&id=<?= $valeur->idPkm ?>">
		<img src="images/<?= $valeur->espece; ?>.jpg" alt="<?= $valeur->espece; ?>" width="100px" height="100px"></a></td>
		<td style="text-align: justify;"> <?php if ($valeur->sexe) echo "F"; else echo "M"; ?> </td>
		<td> <a href="./index.php?page=detail&id=<?= $valeur->idPkm ?>"> <?= $valeur->espece; ?></a> </td>
		<td style="text-align: justify;"> <?= $valeur->description ?> </td>
		<td><a href="./index.php?page=detail&id=<?= $valeur->idPkm ?>"><button>Voir le pokémon</button></a></td>
	</tr>
	<?php } ?>

</table>

<?php } 