<?php
	session_start();
	include_once"../lib/alert.php";
	include_once"../lib/users.php";
	include_once"../lib/db.php";
	include_once("../lib/secure.php");
	$database = new Db;
	$database->connect();
	
	//visitor::log($database);	// enregistre l'ip dans la base de données
	
	//--------------------------Vérifie dans la bdd si vous êtes admin -----------------------------------
	/*
			Simple vérification du statut administrateur pour accéder aux pages sensibles, redirection et affichage de la raison
			d'expulsion en cas de manque de privilèges pour l'utilisateur.
	*/
	$database->select('users','privilege','1',$resultStatus);
	$count=0;
		
	foreach ($resultStatus as $user)
	{
			if($user['pseudo']==$_SESSION['usr-data']['pseudo']) $count++;
	}
			
	if($count==1)
	{
		 // echo 'vous etes admin';
	}
	else 
	{
			// echo 'vous n\'etes pas admin';
			header('Location:/');
			Alert::danger('Vous n\'avez pas les privilèges requis pour accéder à cette page, statut administrateur demandé.');
			$_SESSION['usr-isSuperUser']=0;
			die();
	}
//--------------------------------------------------------------
			
	Secure::post();
 
	$id=$_GET['questionId'];
		
			
	if ($database->update('questions',array('validate'),array('1'),'id',"$id"))
	{
		Alert::success("Question validée !");
		header('Location: /admin/novalidliste.php');
		die();
	}
		
	else
	{
		Alert::danger("Erreur","Erreur inconnue lors de la modification dans la base de donnée");
		header('Location: /admin/novalidliste.php');
		die();
	}
			
	
	
?>