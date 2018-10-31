<?php
	session_start();
	
	include_once("../lib/misc.php");
	include_once("../lib/alert.php");
	include_once("../lib/db.php");
	include_once("../lib/visitor.php");
	include_once("../lib/secure.php");
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données

	$_POST['lastname'] = isset($_POST['lastname']) ? $_POST['lastname'] : NULL;
	$_POST['firstname'] = isset($_POST['firstname']) ? $_POST['firstname'] : NULL;
	$_POST['mail'] = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	$_POST['pseudo'] = isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL;
	$_POST['password'] = isset($_POST['password']) ? $_POST['password'] : NULL;
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php
			Misc::genericCss();
			Misc::bootstrap();
			Misc::genericIcon();
			Misc::genericLogo();
		?>
		<title>Inscription</title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="../js/amis.js"></script>
	</head>
	<?php
		Analytics::track();
	?>
	<body>
		<?php
			Misc::topNavBar("Inscription"); 
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Alert::display();
		?>
		<div class="container" style="margin-top : 100px; width : 300px;">
			
			<form class="form-signin" action="../users/process_signup.php" method="post">
				
				<h2 class="form-signin-heading text-center text-white">Inscrivez-vous</h2>
				<label for="inputLastname" class="sr-only">Nom:</label>
				<input style ="opacity:0.8;" type="text" maxlength ="30" name="lastname" id="inputLastname" class="form-control" placeholder="Nom" onkeypress="verifierCaracteres(event); return false;" required autofocus/>
				<label for="inputFirstname" class="sr-only">Prénom:</label>
				<input style ="opacity:0.8;" type="text" maxlength ="30" name="firstname" id="inputFirstname" class="form-control" placeholder="Prénom" onkeypress="verifierCaracteres(event); return false;" required autofocus/>
				<label for="inputPseudo" class="sr-only">Pseudo:</label>
				<input style ="opacity:0.8;" type="text" maxlength ="30" name="pseudo" id="inputPseudo" class="form-control" placeholder="Pseudo" onkeypress="verifierCaracteres(event); return false;" required autofocus/>	
				<label for="inputPassword" class="sr-only">Mot de passe:</label>
				<input style ="opacity:0.8;" type="password" maxlength ="40" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" onkeypress="verifierCaracteres(event); return false;" required autofocus/>
				<label for="inputMail" class="sr-only">E-mail:</label>
				<input style ="opacity:0.8;" type="email" maxlength ="50" name="mail" id="inputMail" class="form-control" placeholder="Mail" onkeypress="verifierCaracteres(event); return false;" required autofocus/>	
				<br/>
				<button style ="opacity:0.8;" class="btn btn-lg btn-danger btn-block" type="submit">S'inscrire</button>
				
			</form>
			
		</div>
		
		<?php Misc::bottomNavBar("Inscription"); ?>
		
	</body>
	
</html>