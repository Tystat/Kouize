<?php
	session_start();
	include_once ('../lib/db.php');
	include_once ('../lib/question.php');
	include_once ('../lib/users.php');
	include_once ('../lib/alert.php');
	include_once ('../lib/visitor.php');
	if (!Users::isSuperUser())
	{
		header ('Location: /');	// Vérifie si l'utilisateur est admin, le renvoi sur l'index s'il ne l'est pas.
		die();   
	}
	
	$db = new Db;   
	$db->connect(true);
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	//--------------------------Vérifie dans la bdd si vous êtes admin -----------------------------------
	/*
		Simple vérification du statut administrateur pour accéder aux pages sensibles, redirection et affichage de la raison
		d'expulsion en cas de manque de privilèges pour l'utilisateur.
	*/
	$db->select('users','privilege','1',$resultStatus);
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
	
	{
		//Fonctionne
		$id=$_GET['id'];
		try
		{
			$db->del('questions','id',$id);
			Alert::success('Succès','La question est bien supprimée');
			header('Location: liste.php');
		}
		catch(Exception $e)
		{
			Alert::danger('Erreur','Une erreur est survenue pendant la suppression');
			header('Location: liste.php');
		}
	}
	
?>