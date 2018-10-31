<?php
	session_start();

	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
	// ------------------------------ SECURITY -------------------------------------
	
	if(Users::isLogged()==false){
		Alert::warning("Vous n'êtes pas connecté","On ne peut supprimer quelqu'un de non-connecté");
		header('Location: /');
		die();
	}
	
	Secure::post();
	
	if (!Secure::arePost(array ('mailConf','mdpConf')))
	{
		Alert::Danger('Impossible','Vous devez confirmer votre adresse mail et votre mot de passe pour pouvoir supprimer le compte');
		header('Location: /');
		//echo "pas rempli";
		die();
	}
	
	$mailConf = $_POST['mailConf'];
	$mdpConf = $_POST['mdpConf'];
	
// ------------------------------ PROCESSING -----------------------------------
	
	$dB = new Db;
	$dB->connect(true);
	//visitor::log($dB);	// enregistre l'ip dans la base de données
	$users=new Users($dB);
	
	//verification du mail
	if ($mailConf!=$_SESSION['usr-data']['mail'])
	{
		Alert::Danger('Adresse mail ou mot de passe inconnu', 'Mail ou code érroné.');
		header('Location: /');
		//echo "mauvais mail";
		die();
	}
	
	//vérifiaction de mdp
	if (!password_verify($mdpConf,$_SESSION['usr-data']['password']))
	{
		Alert::Danger('Adresse mail ou mot de passe inconnu', 'Mail ou code érroné.');
		header('Location: /');
		//echo "mauvais mdp";
		die();
	}
	
	//suppression de la base de donnée
	$users->supp($_SESSION['usr-data']['mail']);
	Users::logout();
	
	//vérification de la bonne suppression
	if(!$_SESSION['usr-data'])
	{
		Alert::warning('Compte supprimé',"Votre compte a été supprimé avec succès");
		header('Location: /');
		//echo "supprimé";
		die();
	}
	
	//en cas de problème inconnu
	Alert::Danger('Problème de suppression de compte', "Nous n'avons pas pu supprimer votre compte");
	header('Location: /');
	//echo "pas supprimé";
	die();
?>