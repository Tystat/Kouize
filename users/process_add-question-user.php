<?php
	session_start();
	
	include_once("../lib/alert.php");
	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once('../lib/question.php');
	include_once('../lib/users.php');
	include_once('../lib/visitor.php');
	
	$database = new Db;
	$question = new Question($database);
	$database->connect();
	//visitor::log($database);	// enregistre l'ip dans la base de données
	
	Secure::post();
	
	if (empty($_POST['questionText']) || empty($_POST['questionAnswer']) || empty($_POST['questionProposal1']) || empty($_POST['questionProposal2']) || empty($_POST['questionProposal3']))
	{
		Alert::danger("Erreur d'envoi","Vous devez remplir <strong>tous</strong> les champs");
		header ("Location: /users/add-question-user.php");
		die();
	}
		
	else
	{
		
		$insertData=array(
			
			$_POST['questionText'],
			$_POST['questionAnswer'],
			$_POST['questionProposal1'],
			$_POST['questionProposal2'],
			$_POST['questionProposal3'],
			$_POST['questionTheme']);
			
		if (($question->add($_POST['questionText'],$_POST['questionAnswer'],$_POST['questionProposal1'],$_POST['questionProposal2'],$_POST['questionProposal3'],$_POST['questionTheme'])))
		{
				Alert::danger("Erreur d'envoi","Erreur inconnue lors de l'envoi dans la base de donnée");
				header ("Location: /users/add-question-user.php");
				die();
		}
		else
		{
			Alert::success("Envoi réussi!");
			header('Location: /users/add-question-user.php'); 
			die();
		}
	}
?>