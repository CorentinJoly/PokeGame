<?php
if (!isset($_SESSION['auth']))
	createFlashMessage('error', 'Vous devez être connecté', 'home');
?>

<script type="text/javascript">

function pokemonChange(selectObj) { 
 	var idx = selectObj.selectedIndex; 
    var which = selectObj.options[idx].value; 
	document.getElementById("imagePreview").src = "images/"+which+".jpg";
	document.getElementById("imagePreview").style.width = '100px';
	document.getElementById("imagePreview").style.height = '100px';
}

</script>
<h2>Ajouter un pokémon capturé</h2>
<div class="container">

	<form method="POST">
		<input type="hidden" name="action" value="new">
		
		<table>

		<?php $reponses = getEspecePokemon(); ?>

		<tr>
			<td width="30%"><label><b>Espèce</b></label></td>
			<td width="30%">
				<select name="espece" required onchange="pokemonChange(this);">
				<option value="-1">--</option>
				<?php foreach ($reponses as $valeur) { ?> 
				<option value="<?= $valeur->espece; ?>"><?= $valeur->espece; ?></option>
				<?php } ?>
				</select>
			</td>
			<td width="100px" height="100px" style="text-align: center;"><img id="imagePreview" alt=""></td>
		</tr>

			<tr><td colspan="3"><button type="submit">Ajouter</button></td></tr>
	</table>

	</form>
</div>