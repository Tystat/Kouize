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
	
			
	$idgame=$_GET['idgame'];
	$cle=$_GET['codegame'];
		
	if ($db->update('players',array('statut'),array('0'),'id_game',"$idgame"))
	{
		Alert::success("Question validée !");
		$startDateTimestamp = date ("Y-m-d H:i:s");
		$db->updateMult('games',array('timestamp'), array($startDateTimestamp),array('codegame'),array("=$cle"),false);
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