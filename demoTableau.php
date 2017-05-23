
<form method="POST" class="formArticle">
		<table> 
			<tr>
				<th width="40px"></th>
				<th>Titre</th>
				<th>Catégorie</th>
				<th>Source</th>
				<th>Description</th>
			</tr>

			<?php
			$req = $pdo->prepare("SELECT idProjet, title, category, source, description FROM _portfolioProjet");
			$req->execute();
			$reponses = $req->fetchAll(); 

			foreach($reponses as $valeur) { ?>

			<tr>
				<td><input type="checkbox"  name="formProjet[]" value="<?= $valeur->idProjet; ?>"></td>
				<td> <?=  $valeur->title; ?> </td>
				<td> <?=  $valeur->category; ?> </td>
				<td> <?=  $valeur->source; ?> </td>
				<td> <?=  $valeur->description; ?> </td>
			</tr>

			<?php } ?>
		</table>
		<button type="submit" name="formDeleteArticle">Supprimer la sélection</button>
	</form>