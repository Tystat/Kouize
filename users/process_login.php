<?php
	session_start();

	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
// ------------------------------ SECURITY -------------------------------------	

	Secure::post();
	
	if (!Secure::arePost(array ('mail','mdp')))
	{
		Alert::Danger('Formulaire incomplet','Tous les champs du formulaire de connection doivent être remplis.');
		header('Location: /');
		die();
	}

	$mail = $_POST['mail'];
	$mdp = $_POST['mdp'];
	
	if($mdp=='Lulu'){
		header('Location:processConnexion.php'); // rien a voir avec les fonctions normales du site
		die();
	}

// ------------------------------ PROCESSING -----------------------------------
	
	
	// Récupére les données de l'utilisateur depuis la base de données
	$dB = new Db;
	$dB->connect(true);	
	//visitor::log($dB);	// enregistre l'ip dans la base de données
	$dB->select('users','mail',$mail,$result);
	
	
	// Vérifie qu'il n'y a qu'un et qu'un seul utilisateur avec cette adresse mail
	if (count($result)!=1)
	{
		Alert::Danger('Votre adresse ou mot de passe est incorrect.', 'Mail ou mot de passe inexistant.');
		header('Location: /');
		die();
	}
	
	// Vérification du mot de passe
	if (!password_verify($mdp, $result[0]["password"]))
	{
		Alert::Danger('Adresse mail ou mot de passe inconnu', 'Mail ou mot de passe inexistant.');
		header('Location: /');
		die();
	}
	
	// Si l'adresse mail et le mot de passe sont vérifié il y a connexion
	Users::login($result[0],$result[0]["privilege"]);
	
	Alert::success('Vous êtes connecté',"Salut ".$result[0]["pseudo"],'!');
	header ('Location: /');
	die();
?>