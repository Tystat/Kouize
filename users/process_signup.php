<?php
	session_start();

	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
	Secure::post();
	
	$lastname = $_POST['lastname'];
	$firstname = $_POST['firstname'];
	$mail = $_POST['mail'];
	$pseudo = $_POST['pseudo'];
	$password = $_POST['password']; 

// ------------------------------ SECURITY -------------------------------------
	
	$password_crypt=password_hash( $password , PASSWORD_BCRYPT );
// ------------------------------ PROCESSING -----------------------------------
	$db = new Db();
	$db->connect();
	//visitor::log($db);	// enregistre l'ip dans la base de données
	$users =  new Users($db);
	if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $mail)) {
		$verifMail = 1;
	} else {
		$verifMail = 0;
	}
	
	if($lastname==NULL ||$firstname==NULL ||$mail==NULL ||$pseudo==NULL ||$password_crypt==NULL)
	{}
	else if ($verifMail == 0){
		Alert::danger('Inscription invalide', 'Veuillez choisir une autre adresse e-mail');
		header('Location: ../inscription.php');
	}
	else if (($users->isMailInDB($mail))){
		Alert::danger('Inscription invalide', 'Veuillez choisir une autre adresse e-mail');
		header('Location: ../inscription.php');
	}
	else if (!($users->isMailInDB($mail))){
		$users->add($lastname, $firstname, $mail, $pseudo, $password_crypt);
		$db->select('users','mail',$mail,$resultco);
		Users::login($resultco[0],$resultco[0]["privilege"]);
		Alert::success('Inscription validé', 'Vous pouvez désormais profiter de notre service');
		header('Location: /');
	}
?>