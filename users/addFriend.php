<?php
session_start();
    
    include_once('../lib/db.php');
    include_once('../lib/alert.php');
	include_once('../lib/visitor.php');
	include_once('../lib/analytics.php');
	
	$db = new Db;
	$db->connect(true);
	
	Visitor::log($db);
	$pseudo = $_SESSION['usr-data']['pseudo'];
	$friend = $_POST['search']; // recupération du pseudo du joueur à ajouter en ami.
	
	$db->select('users','pseudo',$friend,$resultFriend,'',false);	// recherche de la bonne correspondance entre le pseudo entré et ceux disponibles dans la BDD
	$verif = $resultFriend[0];
	
	$db->selectMult('friends',array('friend1','friend2'),array("=$pseudo","=$friend"),$resultSameFriend,'',false);
	$verifSame = $resultSameFriend[0];
	
	if(!isset($verifSame)){
		if(isset($verif)){
			$db->insert('friends',array('friend1','friend2'),array($_SESSION['usr-data']['pseudo'],$friend));
			$db->insert('friends',array('friend2','friend1'),array($_SESSION['usr-data']['pseudo'],$friend));
			Alert::success("Félicitations ! ",$message='Vous vous êtes fait un pote !');
		}
		else {
		Alert::danger("Attention",$message='Veuillez avoir la sympathie d\'utiliser des pseudos existants.');
		}
	}
	else {
		Alert::danger("Attention",$message='Cette personne est déjà votre ami.');
	}
	header("location:".$_SERVER['HTTP_REFERER']);
?>
