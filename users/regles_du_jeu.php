<?php
	session_start();
	include_once("../lib/misc.php");
	include_once("../lib/db.php");
	include_once("../lib/visitor.php");
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true);
	
	//visitor::log($db);
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

		<title>Règles - Kouize</title>
		<meta name="description" content="Testez Kouize le nouveau jeu original de quiz sur internet !">
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
			Misc::topNavBar("Règles");
			Misc::loginModalForm();
			Misc::logoutModalForm();
		?>
		<style>
			
		</style>
		<!--Main Page-->
		<div class="container mt-5 pb-5">
			<div class="text-justify wmax-1024 mx-auto ">
				<br> 
				<p class="h1 text-center my-3" style="color:dark"><b>Règles du jeu</b></p>
				<div style="opacity: 0.9;" class= "container bg-light text-dark rounded px-5 py-2">
					<p class="lead"><b>Pour jouer à Kouize, il vous faut : </b>
						<ul class="lead my-3 text-left px-0">
							<li>Simplement créer/rejoindre une session de jeu avec un code généré pour chaque partie.</li>
							<li>Être un minimum de 2 joueurs pour s'amuser (vous pouvez aussi jouer en solitaire).</li>
						</ul>
					</p>
				</div>
				<br>
				<br>
				<div style="opacity: 0.9;" class= "container bg-light rounded px-5 py-2">
					<ul class="lead my-3 text-left text-justify px-0">
						<p class="lead mx-1 my-4">
							<li>Lorsque que vous lancez une partie de <b>Kouize</b> avec vos amis, vous devrez vous confronter dans une bataille de questions de culture générale.</li><br>
							<li>Le jeu se déroule sur un plateau de 30 cases.</li><br>
							<li>Trouver la bonne réponse vous assure l'avancée de votre pion sur le plateau de jeu. En commençant à la case départ, faites avancer votre pion de case en case, mais attention : les cases peuvent être neutres, avec des bonus ou des malus ! (Indiquées par les coffres.) </li><br> 
							<li>On avance sur le plateau d’un nombre de cases équivalent à la difficulté de la question.</li></br>
						    <li>Si un joueur arrive pendant une partie déjà commencée, il démarre à la case départ.</li>
						</p>
					</u1>
				</div>
			</div>
		</div>
		<?php
			Misc::bottomNavBar(" ");
		?>
  </body>
</html>