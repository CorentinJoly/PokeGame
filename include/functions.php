<?php
function debug($variable)
{
	echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length)
{
	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

/*
* Le type est 'danger' ou 'success'
* La 'page' correspond à la redirection
* Le 'message' s'affichera sur la page ou l'on est redirigé (une seule fois)
*/
function createFlashMessage($type, $message, $page)
{
	$_SESSION['flash'][$type] = $message;
	header("Location: ./index.php?page=$page");
	exit();
	
}

function getPieces($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT pieces FROM _pokemonDresseur WHERE idDresseur = ?");
	$req->execute([$idDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

function getDresseur($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT * FROM _pokemonDresseur WHERE idDresseur = ?");
	$req->execute([$idDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

function confirmInscription($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("UPDATE _pokemonDresseur set confirmationToken = NULL, confirmationDate = NOW() WHERE idDresseur= ?");
	$req->execute([$idDresseur]);
}
function getNbPokemonEnVente($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT COUNT(idPkm) as nbPokemon FROM _pokemonAssoDresseur WHERE idDresseurConcerne <> ? AND enVente = 1");
	$req->execute([$idDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

function getListPkmEnVente($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT idPkm, espece, nomDress, level, prix, idDresseurConcerne FROM _pokemon, _pokemonAssoDresseur, _pokemonDresseur WHERE _pokemon.numeroPokedex=_pokemonAssoDresseur.idPokemonConcerne AND _pokemonDresseur.idDresseur=_pokemonAssoDresseur.idDresseurConcerne AND enVente= 1 AND idDresseurConcerne <> ?");
	$req->execute([$idDresseur]);
	$reponses = $req->fetchAll(); 

	return $reponses;
}

function getPokemonFromDresseur($idPokemon)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT * FROM _pokemonAssoDresseur WHERE idPkm = ?");
	$req->execute([$idPokemon]);
	$reponse = $req->fetch();

	return $reponse;
}

function getPokemon($numPokedex)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT * FROM _pokemon WHERE numeroPokedex = ?");
	$req->execute([$numPokedex]);
	$reponse = $req->fetch();

	return $reponse;
}

function getDateLastTraining($idPokemon)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT dateLastTrain FROM _pokemonAssoDresseur WHERE idPkm = ?");
	$req->execute([$idPokemon]);
	$reponse = $req->fetch()->dateLastTrain;

	return $reponse;
}

function getEspecePokemon()
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT espece FROM _pokemon");
	$req->execute();
	$reponses = $req->fetchAll(); 

	return $reponses;
}

function getListPokemon($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT idPkm, numeroPokedex, espece, description, sexe FROM _pokemon, _pokemonAssoDresseur WHERE _pokemon.numeroPokedex=_pokemonAssoDresseur.idPokemonConcerne AND idDresseurConcerne = ?");
	$req->execute([$idDresseur]);
	$reponses = $req->fetchAll(); 

	return $reponses;
}


function getNbPokemonDresseur($idDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT COUNT(idPkm) as nbPokemon FROM _pokemonAssoDresseur WHERE idDresseurConcerne = ?");
	$req->execute([$idDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

function getDresseurFromNom($nomDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT idDresseur from _pokemonDresseur where nomDress = ?");
	$req->execute([$nomDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}


