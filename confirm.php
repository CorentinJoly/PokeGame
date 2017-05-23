<?php
require_once 'include/bdd.php';
include 'include/functions.php';

$user_id = $_GET['id'];
$token = $_GET['token'];

$req = $pdo->prepare("SELECT * FROM _pokemonDresseur WHERE idDresseur = ?");
$req->execute([$user_id]);

$user = $req->fetch();
session_start();

if($user && $user->confirmationToken == $token){
	$req = $pdo->prepare("UPDATE _pokemonDresseur set confirmationToken = NULL, confirmationDate = NOW() WHERE idDresseur= ?");
	$req->execute([$user_id]);
	$_SESSION['auth'] = $user;
	createFlashMessage('success', 'Votre compte a bien été validé', 'pokemons');
}
else {
	createFlashMessage('danger', 'Ce token n\'est plus valide', 'pokemons');
}