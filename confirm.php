<?php
include 'include/functions.php';

$user_id = $_GET['id'];
$token = $_GET['token'];

$user = getDresseur($user_id);

session_start();

if($user && $user->confirmationToken == $token){
	confirmInscription($user_id);
	$_SESSION['auth'] = $user;
	createFlashMessage('success', 'Votre compte a bien été validé', 'pokemons');
}
else
	createFlashMessage('danger', 'Ce token n\'est plus valide', 'pokemons');