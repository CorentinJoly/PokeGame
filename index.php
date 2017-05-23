<?php 
require_once 'include/functions.php';
require_once 'include/bdd.php'; 
require_once 'recaptcha.php';
include 'include/header.php';

if (isset($_SESSION['auth']))
	$user = $_SESSION['auth']; 

function getFieldFromForm($name){
    return isset($_POST[$name])?$_POST[$name]:(isset($_GET[$name])?$_GET[$name]:null);
}

$page = getFieldFromForm("page");
if(!isset($page)){
    $page = "pokemons";
}


$action=getFieldFromForm("action");
switch($action){
	case "inscription":

		//Vérif captcha google
		$captcha = new Recaptcha('6LcBHg4TAAAAAOuISetNqt31NuAVCfQxHA-lSOeF');
		if($captcha->checkCode($_POST['g-recaptcha-response']) == false)
			createFlashMessage('danger', 'Le captcha ne semble pas valide', 'inscription');

		//Vérif username
		if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) 
			createFlashMessage('danger', 'Merci de ne pas mettre de caractères spéciaux dans votre pseudo', 'inscription');
		else {
			$req = $pdo->prepare("SELECT idDresseur from _pokemonDresseur where nomDress = ?");
			$req->execute([$_POST['username']]);
			$user = $req->fetch();
			if ($user) 
				createFlashMessage('danger', 'Ce pseudo est déjà pris', 'inscription');
		}
		
		//Vérif du mail
		if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
			createFlashMessage('danger', 'Adresse email invalide', 'inscription');
		else {
			$req = $pdo->prepare("SELECT mailDress from _pokemonDresseur where mailDress = ?");
			$req->execute([$_POST['mail']]);
			$mail = $req->fetch();
			if ($mail)
				createFlashMessage('danger', 'Cet mail est déjà utilisé', 'inscription');
		}

		//Vérif password
		if (empty($_POST['password']) || $_POST['password'] != $_POST['password-confirm'])
			createFlashMessage('danger', 'Mauvais mot de passe', 'inscription');
		//On enregistre dans la BDD
		$req = $pdo->prepare("INSERT INTO _pokemonDresseur set nomDress = ?, pieces = ?, mdpDress = ?, mailDress= ?, confirmationToken = ?");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$req->execute([$_POST['username'], 5000, $password, $_POST['mail'], $token]);
		$user_id = $pdo->lastInsertId();
		//On insère le nouveau dresseur et son nouveau pokémon dans la table d'asso --> Dresseur / Pokémon
		$sexe= rand(0,1);
		$req = $pdo->prepare("INSERT INTO _pokemonAssoDresseur SET idPokemonConcerne = ?, idDresseurConcerne = ?, sexe = ?");
		$req->execute([$_POST['idPokemon'], $user_id, $sexe]);
		
		//On envoie un mail de confirmation avec le token
		mail($_POST['mail'], "Confirmation de votre compte", "Merci de cliquer sur ce lien pour valider votre compte \n\n http://corentin-joly.fr/CoursInf8/TD4Pokedex/confirm.php?id=$user_id&token=$token");
		createFlashMessage('success', 'Un email de confirmation vous a été envoyé pour valider votre compte', 'inscription');
		break;

	/*
	*Autre cas
	*/
	case "connexion":
		$req = $pdo->prepare("SELECT * FROM _pokemonDresseur WHERE (nomDress = :username OR mailDress = :username) AND confirmationDate IS NOT NULL");
		$req->execute(['username' => $_POST['username']]);
		$user = $req->fetch();

		if(password_verify($_POST['password'], $user->mdpDress)) {
			$_SESSION['auth'] = $user;
			createFlashMessage('success', 'Vous êtes maintenant connecté', 'pokemons');
		}
		else{
			createFlashMessage('danger', 'Identifiant ou mot de passe incorrect', 'connexion');
		}
		break;

	/*
	*Autre cas
	*/
	case "new":
		//On récupère les infos du pokémon
		$req = $pdo->prepare("SELECT * FROM _pokemon WHERE espece = ?");
		$req->execute([$_POST['espece']]);
		$pokemon = $req->fetch();
		$sexe= rand(0,1);
		//On récupère l'id de l'utilisateur courant
		$user_id = $_SESSION['auth']->idDresseur;
		//On ajoute le pokémon et l'user dans la table d'association. On fait +1 dans le nombre de pokémon du dresseur
		$req = $pdo->prepare("INSERT INTO _pokemonAssoDresseur SET idPokemonConcerne = ?, idDresseurConcerne = ?, sexe = ?");
		$req->execute([$pokemon->numeroPokedex, $user_id, $sexe]);

		createFlashMessage('success', 'Le pokémon a été ajouté à votre liste', 'pokemons');
		break;

	/*
	*Autre cas
	*/
	case "miseEnVente":
		//On prépare la requête pour mettre le pokémon en vente (on récuprère son idPkm et le prix de mise en vente)
		$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET enVente =1, prix = ? WHERE idPkm = ?");
		$req->execute([$_POST['prix'], $_POST['idPokemonDetail']]);

		createFlashMessage('success', 'Le pokémon a bien été mise en vente', 'pokemons');
		break;

	/*
	*Autre cas
	*/
	case "retirerVente":
		//On prépare la requête pour mettre le pokémon en vente (on récuprère son idPkm et le prix de mise en vente)
		$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET enVente =0, prix = 0 WHERE idPkm = ?");
		$req->execute([$_POST['idPokemonDetail']]);

		createFlashMessage('success', 'Le pokémon a bien été retiré de la vente', 'pokemons');
		break;

	/*
	*Autre cas
	*/
	case "achat":
		$differencePrix = $_POST['prix'] - $user->pieces;
		if($differencePrix > 0)
			createFlashMessage('danger', 'Il vous manque '.$differencePrix.' pièces pour acheter ce pokémon', 'annonces');
		else {
			$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET prix = 0, enVente = 0, idDresseurConcerne = ? WHERE idPkm = ?");
			$req->execute([$user->idDresseur, $_POST['idPokemonAchete']]);

			$req = $pdo->prepare("UPDATE _pokemonDresseur SET pieces = pieces + ? WHERE idDresseur = ? ");
			$req->execute([$_POST['prix'], $_POST['idDresseurConcerne']]);

			$req = $pdo->prepare("UPDATE _pokemonDresseur SET pieces = pieces - ? WHERE idDresseur = ? ");
			$req->execute([$_POST['prix'], $user->idDresseur]);

			createFlashMessage('success', 'Félicitations ! Vous venez d\'acheter un pokémon', 'pokemons');
		}
		exit();
		
		break;

	/*
	*Autre cas
	*/
	case 'entrainer':
		$xpGagne = rand (10, 30);
		$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET dateLastTrain = NOW(), experience = experience + ? WHERE idPkm = ?");
		$req->execute([$xpGagne, $_POST['idPokemonDetail']]);
		createFlashMessage('success', 'Votre pokémon est bien parti s\'entrainer, il sera de retour dans 1h', 'pokemons');
		break;
}


if (!include "$page.php") {
	header( "refresh:5;url=index.php" ); 
	?>
	
	<div class="presentation" align="center">
		<h2 class="home__title">Oups..</h2>
		<iframe src="//giphy.com/embed/yhfTY8JL1wIAE" width="480" height="318.1714285714286" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
		<br>
		La page demandée n'a pas été trouvée, <br> vous allez être redirigé dans 5sec. <br><br>
		Sinon, cliquez <a href="index">ici</a>
	</div>

<?php }
include 'include/footer.php';