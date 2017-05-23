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
	$req->execute([$user->idDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}