<?php
	session_start();
	
	include_once"../lib/alert.php";
	include_once"../lib/db.php";
	include_once("../lib/secure.php");
	include_once('../lib/question.php');
	include_once('../lib/users.php');
	include_once('../lib/visitor.php');
	
	$database = new Db;
	$question = new Question($database);
	$database->connect();
	
	//visitor::log($database);
	
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
		Alert::danger('Vous n\'avez pas les privilèges requis pour accéder à cette page, statut administrateur demandé.');
		header('Location:/');
		$_SESSION['usr-isSuperUser']=0;
		die();
	}
	//--------------------------------------------------------------
	
	Secure::post();
	
	if (empty($_POST['questionText']) || empty($_POST['questionAnswer']) || empty($_POST['questionProposal1']) || empty($_POST['questionProposal2']) || empty($_POST['questionProposal3']))
	{
		Alert::danger("Erreur d'envoi","Vous devez remplir <strong>tous</strong> les champs");
		header ("Location: /admin/add-question.php");
		die();
	}
	if (strlen($_POST['questionText'])>105 || strlen($_POST['questionAnswer'])>28 || strlen($_POST['questionProposal1'])>28 || strlen($_POST['questionProposal2'])>28 || strlen($_POST['questionProposal3'])>28)
	{
		Alert::danger("Erreur d'envoi","105 caractères max par question et 28 caractères max par réponse");	
		header ("Location: /admin/add-question.php");
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
			
		if (($question->add($_POST['questionText'],$_POST['questionAnswer'],$_POST['questionProposal1'],$_POST['questionProposal2'],$_POST['questionProposal3'],$_POST['questionTheme'],1)))
		{
				Alert::danger("Erreur d'envoi","Erreur inconnue lors de l'envoi dans la base de donnée");
				header ("Location: /admin/add-question.php");
				die();
		}
		else
		{
			Alert::success("Envoi réussi!");
			header('Location: /admin/add-question.php'); 
			die();
		}
	}
?>