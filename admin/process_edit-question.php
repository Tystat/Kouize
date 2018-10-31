<?php
	session_start();
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once('../lib/visitor.php');
	
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
	}
	else 
	{
			header('Location:/');
			Alert::danger('Vous n\'avez pas les privilèges requis pour accéder à cette page, statut administrateur demandé.');
			$_SESSION['usr-isSuperUser']=0;
			die();
	}
	//--------------------------------------------------------------
		
	if (!Users::isSuperUser())
	{
		header ('Location: /');	// Vérifie si l'utilisateur est admin, le renvoi sur l'index s'il ne l'est pas.
		die();   
	}
			
	Secure::post();
	
	if (empty($_POST['questionText']) || empty($_POST['questionAnswer']) || empty($_POST['questionProposal1']) || empty($_POST['questionProposal2']) || empty($_POST['questionProposal3']))
	{
		Alert::danger("Erreur","Vous devez remplir <strong>tous</strong> les champs");
		header('Location: /admin/liste.php');
		die();
	}
	
	else
	{
		
		$insertField=array(
			
			"question",
			"answer",
			"proposal1",
			"proposal2",
			"proposal3",
			"theme");
			
		$insertData=array(
			
			$_POST['questionText'],
			$_POST['questionAnswer'],
			$_POST['questionProposal1'],
			$_POST['questionProposal2'],
			$_POST['questionProposal3'],
			$_POST['questionTheme']);
			

		$database->update("questions",$insertField,$insertData,"id",$_GET['questionId']);	
		
		if ($database->update("questions",$insertField,$insertData,"id",$_GET['questionId']))
		{
			Alert::success("Modification réussie!");
			header('Location: /admin/liste.php');
			die();
		}
		
		else
		{
			Alert::danger("Erreur","Erreur inconnue lors de la modification dans la base de donnée");
			header('Location: /admin/liste.php');
			die();
		}
			
	}
	
?>