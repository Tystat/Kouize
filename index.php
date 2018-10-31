<?php 
		session_start();
		include_once('lib/alert.php');
		include_once('lib/misc.php');
		include_once('lib/visitor.php');
		include_once('lib/db.php');
		include_once('lib/analytics.php');
		
		
		
		$db=new Db;
		$db->connect(true);
		

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<?php
				visitor::log($db);
				Misc::genericCss();
				Misc::bootstrap();
				Misc::genericIcon();
				Misc::genericLogo();
		?>
		<title>Kouize</title>
		<meta name="description" content="Testez Kouize le nouveau jeu original de quiz sur internet !">
		<link rel="stylesheet" href="/css/font-awesome-animation.min.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/amis.js"></script>
	</head>
	<?php
				Analytics::track();
		?>
	<body>
		<?php
				Misc::topNavBar('Accueil');
				Misc::loginModalForm();
				Misc::logoutModalForm();
				Alert::display();
				//Misc::updateLogPlayer();
		?>
		<div class="d-none d-lg-block">
			<div class="text-white mt-5" style="width: 200px; top: 0px; left: 85px; position:fixed; z-index: 1000;">
				<div class="text-center pt-3 faa-bounce animated"><div id="fade">C'est ici pour jouer <i class="fa fa-angle-double-up"></i></div></div>
			</div>
			<div class="text-white mt-5" style="width: 210px; top: 0px; left: 300px; position:fixed; z-index: 1000;">
				<div class="text-center pt-3 faa-bounce animated"><div id="fade2"><i class="fa fa-angle-double-up"></i> Et là pour apprendre</div></div>
			</div>
		</div>
		<div class="d-lg-none">
			<div class="text-white mt-5" style="width: 210px; top: 0px; left: 33px; position:fixed; z-index: 1000;">
				<div class="text-center pt-3 faa-bounce animated"><div id="fade3"><i class="fa fa-angle-double-up"></i> C'est là que ça se passe</div></div>
			</div>
		</div>
		<div class="container-fluid pt-5 mt-5 pb-4">
			<div class="row">
				<div style="opacity:0.9;" class="col-sm order-2 order-sm-1">
					<div class="card text-white bg-dark mb-3 mt-3">
						<div class="card-header text-center"><h3>Pourquoi écrire <span class="text-danger">Quiz</span> quand on peut écrire <b class="text-success">Kouize</b> ?</h3></div>
						<div class="card-body text-center">Créez ou rejoignez une partie, en 2 minutes c'est parti !</div>
					</div>
					<div class="card text-white bg-dark mb-3 mt-3">
						<div class="card-header">Dernières mises à jour</div>
						<div class="card-body scroll-220pxy">
							<h5 class="card-title">21/03/2018</h5>
							<p class="card-text">Plus de 1200 questions jouables</p>
							<h5 class="card-title">20/03/2018</h5>
							<p class="card-text">Plus de 1000 questions jouables</p>
							<h5 class="card-title">13/03/2018</h5>
							<p class="card-text">Plus de 800 questions jouables</p>
							<h5 class="card-title">28/02/2018</h5>
							<p class="card-text">Des parties 100% fonctionnelles sans le plateau pour l'instant</p>
							<h5 class="card-title">27/02/2018</h5>
							<p class="card-text">Plus de 400 questions jouables</p>
							<h5 class="card-title">20/02/2018</h5>
							<p class="card-text">Chat fonctionnel dans le salon d'attente.</p>
							<h5 class="card-title">16/02/2018</h5>
							<p class="card-text">Plus de 250 questions jouables</p>
							<h5 class="card-title">09/02/2018</h5>
							<p class="card-text">Mise en place d'un salon en attendant le lancement d'une partie.</p>
							<h5 class="card-title">05/02/2018</h5>
							<p class="card-text">Mise en place d'un système de création de partie, le jeu n'est cependant toujours pas implémenté complètement.</p>
							<h5 class="card-title">31/01/2018</h5>
							<p class="card-text">Mise à jour du logo (animation), affichage du pseudo, finalisation des règles, changement de la page "jouer" et ajout de questions.</p>
							<h5 class="card-title">26/01/2018</h5>
							<p class="card-text">Première release, site de base sans jeu, pannel administrateur, ajout de questions et inscription / connexion.</p>
						</div>
					</div>
				</div>
				<div style="opacity:0.9;" class="col-sm order-1 order-sm-2">
						<img src="/media/logo.gif" class="img-fluid w-100" alt="Kouize Logo"> </video>
				</div>
			</div>
		</div>
		
		<?php
			Misc::bottomNavBar('Accueil');
		?>
	</body>
	<script>
		$('#fade').delay(7000).fadeOut(400);
		$('#fade2').delay(7000).fadeOut(400);
		$('#fade3').delay(7000).fadeOut(400);
	</script>
</html>