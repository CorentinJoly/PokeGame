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

<h2>Bienvenue au marché Pokémon</h2>

<!-- On calcul le nombre de pièce qu'il reste au dresseur -->

<?php $nbPiece = getPieces($user->idDresseur); ?>

<h3>Solde de pièces : <font color="#F6DC12"> <?= $nbPiece->pieces; ?> </font></h3>

<?php $nbPokemonEnVente = getNbPokemonEnVente($user->idDresseur); ?>

Il y a <?php echo $nbPokemonEnVente->nbPokemon; ?>
<?php 
if ($nbPokemonEnVente->nbPokemon <= 1) 
	echo " pokémon ";
else
	echo " pokémons ";
?>en vente sur le marché
	
<form method="POST" action="index.php">
<input type="hidden" name="action" value="achat">
<table style="margin-top: 80px;"> 
<tr>
	<th width="40px" style="text-align: center;"></th>
	<th style="text-align: center;">Espèce</th>
	<th style="text-align: center;">Niveau</th>
	<th style="text-align: center;">Propriétaire</th>
	<th style="text-align: center;">Prix</th>
</tr>

<?php 
$reponses = getListPkmEnVente($user->idDresseur); 

foreach($reponses as $valeur) { ?>
<input type="hidden" name="idPokemonAchete" value="<?= $valeur->idPkm; ?>">
<input type="hidden" name="prix" value="<?= $valeur->prix ?>">
<input type="hidden" name="idDresseurConcerne" value="<?= $valeur->idDresseurConcerne ?>">
<tr>
	<td style="text-align: center;">
		<img src="images/<?= $valeur->espece; ?>.jpg" alt="<?= $valeur->espece; ?>" width="100px" height="100px">
	</td>
	<td style="text-align: center;"> <?= $valeur->espece; ?> </td>
	<td style="text-align: center;"> <?= $valeur->level; ?> </td>
	<td style="text-align: center;"> <?= $valeur->nomDress; ?> </td>
	<td style="text-align: center;"> <?= $valeur->prix; ?>  </td>
	<td>
		<button type="submit">Acheter le pokémon</button>
	</td>
</tr>
<?php } ?>
</table>
</form>


<?php } 