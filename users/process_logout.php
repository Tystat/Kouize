<?php
	session_start();

	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	//Déconnecte l'utilisateur
	Users::logout();
	
	//Verifie que l'utilisateur est bien déconnecté
	if(Users::isLogged()==false){
		header('Location: /');
		die();
	}
	
	//Si on va jusque là il y a eu problème de deconnexion
	Alert::warning('Echec','Problème de déconnexion.');
	header('Location: /');
	die();
?>