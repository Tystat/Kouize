<?php
	session_start();
	
	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once("../lib/question.php");
	include_once("../lib/visitor.php");
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	//------------------------sécurité-----------------------------------//
	
	Secure::post();
	
	if (!Secure::arePost(array ('pseudoCreate')))
	{
		Alert::Danger('Formulaire incomplet','Entrez un pseudo pour pouvoir créer une partie !');
		header('Location: /users/menu_jouer.php');
		die();
	}
	
	$tpseudo = $_POST['pseudoCreate'];
	$_SESSION['player'] = $_POST['pseudoCreate'];
	
	
	//----------------------------génération de clé + génération du tableau de questions aléatoires pour la partie-----------------------------------//
	
	$clé = rand(0, 9999);  //temporaire en attendant la création de la base de données des parties
	$dB = new Db;
	$dB->connect(true);
	
	$quest = new Question($db);
	$questListe = $quest->getRandQuestion();
	
	$newarrayquest= json_encode($questListe);
	//visitor::log($dB);	// enregistre l'ip dans la base de données
	
	$dB->insert('games',array('nbplayers','codegame','listquestion'),array(1,$clé,$newarrayquest),true); //ajoute dans la table games la clé et initialise le nombre de joueur
	$dB->select('games','codegame',$clé,$result); //récupère la ligne de la table games de la partie qu'on vient de créer
	$dB->insert('players',array('pseudo','id_game','statut'),array($tpseudo,$result[0]['id'],2),true); //ajoute le créateur dans la table players avec le statut d'admin et un id-game correspondant à l'id de la table games crée

	$_SESSION['codegame']=$clé;
	$_SESSION['playerStatus']=2;
	$_SESSION['idgame']=$result[0]['id'];
	$_SESSION['playercreate']=$tpseudo;
	$_SESSION['player']=$tpseudo;

	
	//------------------------redirection sur la page du salon-----------------------------------//
	
	Alert::success('Code : '.$clé,"Partie créée, invitez vos amis !");
	header("Location: /game/salon.php");
	die();

?>