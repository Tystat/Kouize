<?php
session_start();
include_once('../lib/db.php');
include_once('../lib/alert.php');
include_once('../lib/visitor.php');
include_once('../lib/users.php');


    $pseudo=$_GET['pseudo'];    // récupère le pseudo du joueur passé en get dans le formulaire de userGestion.php
	$db=new Db;
	$db->connect(true); // connexion à la bdd
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	$db->del('users','pseudo',$pseudo); //supprime la ligne correspondant au pseudo du joueur, pas de risques de mauvaise suppression car pseudo unique dans la bdd.
	
	header('Location:userGestion.php');
	die();
?>