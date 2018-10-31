<?php
	session_start();

	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
	// ------------------------------ SECURITY -------------------------------------
	
	if(Users::isLogged()==false){
		Alert::warning("Vous n'êtes pas connecté","On ne peut modifier quelqu'un de non-connecté");
		header('Location: /users/modifUser.php');
		die();
	}
	
	Secure::post();
	
	if (!Secure::isPost('mdpConfModif'))
	{
		Alert::Danger('Impossible','Vous devez confirmer votre adresse mail et votre mot de passe pour pouvoir modifier le compte');
		header('Location: /users/modifUser.php');
		//echo "pas rempli";
		die();
	}
	
	$mdpConfModif = $_POST['mdpConfModif'];
	$actualmail = $_SESSION['usr-data']['mail'];
	
// ------------------------------ PROCESSING -----------------------------------
	
	$dB = new Db;
	$dB->connect(true);
	$dB->select('users','mail',$actualmail,$result);
	
	
	//visitor::log($dB);	// enregistre l'ip dans la base de données
	
	//vérifiaction de mdp
	if (!password_verify($mdpConfModif,$_SESSION['usr-data']['password']))
	{
		Alert::Danger('Mot de passe inconnu', 'Code érroné.');
		header('Location: /users/modifUser.php');
		die();
	}
	
	if (Secure::isPost('modifFirstname'))
	{
		$modifFirstname = $_POST['modifFirstname'];
		$dB->update('users',array('firstname'),array($modifFirstname),'mail',$actualmail,true);
	}
	
	if (Secure::isPost('modifLastname'))
	{
		$lastnameModif = $_POST['modifLastname'];
		$dB->update('users',array('lastname'),array($lastnameModif),'mail',$actualmail,true);
	}
	
	if (Secure::isPost('modifPseudo'))
	{
		$ancienPseudo = $_SESSION['usr-data']['pseudo'];
		$pseudoModif = $_POST['modifPseudo'];
		$dB->update('users',array('pseudo'),array($pseudoModif),'mail',$actualmail,true);
		$dB->update('friends',array('friend1'),array($pseudoModif),'friend1',$ancienPseudo,true);
		$dB->update('friends',array('friend2'),array($pseudoModif),'friend2',$ancienPseudo,true);
	}
	
	if (Secure::arePost(array('modifPassword1','modifPassword2')))
	{
		$passwordModif1 = $_POST['modifPassword1'];
		$passwordModif2 = $_POST['modifPassword2'];
		if ($passwordModif1==$passwordModif2)
		{
			$password_crypt=password_hash($passwordModif1,PASSWORD_BCRYPT);
			$dB->update('users',array('password'),array($password_crypt),'mail',$actualmail,true);
		}
		else
		{
			Alert::warning('Erreur',"Entrez 2 fois votre nouveau mot de passe");
			header('Location: /users/modifUser.php');
			die();
		}
	}
	
	$privilegeModif = $_POST['modifPrivilege'];
	if ($privilegeModif!=$result[0]['privilege'])
	{
		$dB->update('users',array('modif_privilege'),array(1),'mail',$actualmail,true);
		Alert::warning('Privilege',"Votre demande est pris en compte");
	}
	
	if (Secure::isPost('modifMail'))
	{
		$mailModif = $_POST['modifMail'];
		$dB->update('users',array('mail'),array($mailModif),'mail',$actualmail,true);
		$dB->select('users','mail',$mailModif,$resultmod1);
		Users::logout();
		Users::login($resultmod1[0],$resultmod1[0]["privilege"]);
	}
	else
	{
		$dB->select('users','mail',$actualmail,$resultmod2);
		Users::logout();
		Users::login($resultmod2[0],$resultmod2[0]["privilege"]);
	}
	
	Alert::success('Compte',"Vos données sont modifiées");
	
	header('Location: /users/modifUser.php');
	die();
?>