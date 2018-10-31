<?php
	session_start();
	include_once('../lib/mail.php');
	include_once('../lib/alert.php');
	include_once('../lib/visitor.php');
	include_once('../lib/db.php');
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	if (empty($_POST['contactFirstName']) || empty($_POST['contactLastName']) || empty($_POST['contactMail']) || empty($_POST['contactText']) || empty($_POST['contactSubject']))
	{
		Alert::danger("Erreur d'envoi","Vous devez remplir <strong>tous</strong> les champs");
		header('Location: /users/support.php');
		die();
	}
	else
	{
		/*Test de la validité du mail*/
		if (!filter_var($_POST['contactMail'], FILTER_VALIDATE_EMAIL))
		{
			Alert::danger("Erreur d'envoi","Votre adresse email est <strong> invalide</strong>");
			header('Location: ../users/support.php');
			die();
		}
		else
		{
			if(!Mail::sendMail($_POST['contactMail'],$_POST['contactFirstName']." ".$_POST['contactLastName'],'thomas-tabuteau@orange.fr',$_POST['contactSubject'],$_POST['contactText']))
			{
				Alert::danger('Erreur','Votre requête n\'a pas été envoyée');
				header('Location: ../users/support.php');
				die();
			}
			else
			{
				Alert::success('Succès','Votre requête est envoyée');
				header('Location: ../users/support.php');
				die();
			}
		}
	}
?>
