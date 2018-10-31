<?php
	session_start();
	include_once ('../lib/db.php');
	include_once ('../lib/question.php');
	include_once ('../lib/users.php');
	include_once ('../lib/alert.php');
	include_once('../lib/visitor.php');
  
		
	$db = new Db;   
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	  
	$pseudoPlayer=$_GET['pseudoPlayer'];
	try
	{
		$db->del('players','pseudo',$pseudoPlayer);
		Alert::success('Succès','Le joueur a été exclu du salon');
		header('Location: salon.php');
	}
	catch(Exception $e)
	{
		Alert::danger('Erreur','Une erreur est survenue pendant la suppression');
		header('Location: salon.php');
	}
	
?>