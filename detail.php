<?php
if (!isset($_SESSION['auth']))
	createFlashMessage('error', 'Vous devez être connecté', 'home');
 else {

//On récupère le pokémon avec ses infos perso (level, dernier entrainement ...)
$id = $_GET['id'];
$pokemonFromTableAsso = getPokemonFromDresseur($id);

//On recupère les infos générales du pokémon (nom, sexe, evolution ...)
$numeroPokedex = $pokemonFromTableAsso->idPokemonConcerne;
$pokemon = getPokemon($numeroPokedex);
?>

<h2 align="center">Infos détaillées</h2>


<form method="POST" action="index.php">
<input type="hidden" name="action" value="entrainer">
<input type="hidden" name="idPokemonDetail" value="<?= $pokemonFromTableAsso->idPkm; ?>">

<table>
	<tr>
		<td colspan="3" style="text-align: center; text-transform: uppercase;"><h3><b><?= $pokemon->espece; ?></b></h3></td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center;"><img src="images/<?= $pokemon->espece; ?>.jpg" alt="<?= $pokemon->espece; ?>" width="100px" height="100px"></td>
	</tr>
	<tr>
		<th>Level:</th>
		<td><?= $pokemonFromTableAsso->level ?></td>
	</tr>
	<tr>
		<th>Expérience:</th>
		<td><?= $pokemonFromTableAsso->experience ?></td>
	</tr>
	
	<tr>
		<th>Description:</th>
		<td style="text-align: justify;"><?= $pokemon->description; ?></td>
	</tr>

	<tr>
		<?php 
		if ($pokemonFromTableAsso->enVente) { ?>
			<td colspan="3" style="text-align: center;">Vous ne pouvez pas entrainer le pokémon tant qu'il est en vente</td>
		<?php 
		} 
		else { 
			//On récupère la date du dernier entrainement
			$dateLastTrain = getDateLastTraining($pokemonFromTableAsso->idPkm);
			//On compare avec la date actuelle qu'on ramène en minute
			$now   = time();
			$date2 = strtotime($dateLastTrain);
			$diff  = $now - $date2;
			$diff = $diff/60;
			if ($diff < 60) { ?>
				<td colspan="3" style="text-align: center;">Vous pourrez ré-entrainer votre pokémon dans <?= (int) (60-$diff); ?> minutes</td>
			<?php }
			else { ?>
				<td  colspan="3" style="text-align: center;"><a><button>Entraîner le pokémon</button></a></td>
		<?php } } ?>	
	</tr>

</table>
</form>



<h2 align="center">Gestion du pokémon</h2>
<?php

//On vérifie si le pokémon est déjà en vente ou non
if ($pokemonFromTableAsso->enVente) { ?>
<form method="POST" action="index.php">
<input type="hidden" name="action" value="retirerVente">
<input type="hidden" name="idPokemonDetail" value="<?= $pokemonFromTableAsso->idPkm; ?>">
<center>Le pokémon est en vente pour <em><?= $pokemonFromTableAsso->prix; ?></em> pièces</center>
<button type="submit">Retirer le pokémon de la vente</button>
</form>

<?php }
else { ?>

<form method="POST" action="index.php">
<input type="hidden" name="action" value="miseEnVente">
<input type="hidden" name="idPokemonDetail" value="<?= $pokemonFromTableAsso->idPkm; ?>">

<table>
	<tr>
		<td width="30%"><label><b>Prix de mise en vente :</b></label></td>
		<td width="30%"><input type="number" name="prix" required min="1" /td>
	</tr>

	<tr>
		<td colspan="3"><button type="submit">Mettre en vente le pokémon</button></td>
	</tr>
</table>

</form>

<?php } }