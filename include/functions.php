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

function verifNom($nomDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT idDresseur from _pokemonDresseur where nomDress = ?");
	$req->execute([$nomDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

//Ligne 42 de l'index
function verifMail($mailDresseur)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT mailDress from _pokemonDresseur where mailDress = ?");
	$req->execute([$mailDresseur]);
	$reponse = $req->fetch();

	return $reponse;
}

function connexion($username)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT * FROM _pokemonDresseur WHERE (nomDress = :username OR mailDress = :username) AND confirmationDate IS NOT NULL");
	$req->execute(['username' => $username]);
	$reponse = $req->fetch();

	return $reponse;
}

function miseEnVente($prix, $idPokemon)
{
	include 'bdd.php';

	$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET enVente =1, prix = ? WHERE idPkm = ?");
	$req->execute([$prix, $idPokemon]);
}

function retirerVente($idPokemon)
{
	include 'bdd.php';
	
	$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET enVente =0, prix = 0 WHERE idPkm = ?");
	$req->execute([$idPokemon]);
}

function getCourbe($idPokemon)
{
	include 'bdd.php';

	$req = $pdo->prepare("SELECT courbe FROM _pokemon P, _pokemonAssoDresseur A WHERE P.numeroPokedex = A.idPokemonConcerne and A.idPkm = ?");
	$req->execute([$idPokemon]);
	$reponse = $req->fetch();

	return $reponse;
}


/**
*
* TEST POUR LES COURBES
**/


//Définit un entrainement
//$id => id du pokemon
//$xp => experience du pokemon
//$niveau = niveau du pokemon
//$courbeXP => courbe xp du pokemon
function setEntrainement($idPkm,$xp,$niveau,$courbeXP){

	include 'bdd.php';

    $xp = $xp + rand(10,30);


    switch($courbeXP){
        case 'R':{
            $niveau = courbeRapide($niveau,$xp);
            break;
        }
        case 'M':{
             $niveau = courbeMoyenne($niveau,$xp);
             break;
         }
         case 'P':{
             $niveau = courbeParabolique($niveau,$xp);
             break;
         }
         case 'L':{
             $niveau = courbeLente($niveau,$xp);
             break;
         }

        default :

            return false;
        break;
    }

	$req = $pdo->prepare("UPDATE _pokemonAssoDresseur SET dateLastTrain = NOW(), experience = experience + ?, level = ? WHERE idPkm = ?");
	$req->execute([$xp, $niveau, $idPkm]);
}




//fonction pour la courbe rapide
//$niveau => niveau du pokemon
//$xp => expérience du pokemon
function courbeRapide($niveau,$xp){

    $xpRestant = $xp;
    while ($xpRestant > 0) {
        $xpNextLevel = 0.8 *(pow($niveau,3));

        if($xpNextLevel > $xp)
            break;

        $niveau++;
        $xpRestant = $xpRestant - $xpNextLevel;
    }
    return $niveau;
}

//fonction pour la courbe moyenne
//$niveau => niveau du pokemon
//$xp => expérience du pokemon
function courbeMoyenne($niveau,$xp){

    $xpRestant = $xp;
    while ($xpRestant > 0) {
        $xpNextLevel = pow($niveau,3);

        if($xpNextLevel > $xp)
            break;

        $niveau++;
        $xpRestant = $xpRestant - $xpNextLevel;
    }
    return $niveau;
}

//fonction pour la courbe parabolique
//$niveau => niveau du pokemon
//$xp => expérience du pokemon
function courbeParabolique($niveau,$xp){
    $xpRestant = $xp;
    while ($xpRestant > 0) {
        $xpNextLevel = 1.2 * pow($niveau,3) - 15 * pow($niveau,2) + 100* $niveau -140;

        if($xpNextLevel > $xp)
            break;

        $niveau++;
        $xpRestant = $xpRestant - $xpNextLevel;
    }

    return $niveau;
}

//fonction pour la courbe lente
//$niveau => niveau du pokemon
//$xp => expérience du pokemon
function courbeLente($niveau,$xp){
    $xpRestant = $xp;

    while ($xpRestant > 0) {
        $xpNextLevel = 1.25 * pow($niveau,3);

        if($xpNextLevel > $xp)
            break;

        $niveau++;
        $xpRestant = $xpRestant - $xpNextLevel;
    }
    return $niveau;
}