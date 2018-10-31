<?php
	session_start();
	
	include_once("../lib/misc.php");
	include_once("../lib/alert.php");
	include_once("../lib/db.php");
	include_once("../lib/visitor.php");
	include_once("../lib/secure.php");
	include_once('../lib/analytics.php');
		
	
	// Connexion à la base de données
	$db= new Db;
	$db->connect(true);
	
	// Enregistrement de l'IP dans la base de donnée
	//visitor::log($db);

?>
<!DOCTYPE html>
<hmtl>
	<head>
		<title>Aide - Kouize</title>
		
		<?php 
			Misc::genericCss();
			Misc::bootstrap();
			Misc::genericIcon();
			Misc::genericLogo();
		?>
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
			Misc::topNavBar("Aide"); 
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Alert::display();
		?>
		
		
		
		<?php Misc::bottomNavBar("Aide"); ?>
	</body>
</hmtl>