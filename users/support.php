<?php
	session_start();
	include_once('../lib/users.php');
	include_once('../lib/db.php');
	include_once('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/question.php');
	include_once('../lib/visitor.php');
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<meta http-equiv="content-language" content="fr-FR">
		<title>Support - Kouize</title>
		<meta name="description" content="Testez Kouize le nouveau jeu original de quiz sur internet !">
		<?php
			Misc::genericCSS();
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
			Misc::topNavBar("Support"); 
			Alert::display();
			Misc::loginModalForm();
			Misc::logoutModalForm();
		?>
		<div class="container mt-5 pt-5 pb-5">
			<div class="card">
				<h5 class="card-header">Contacter le support</h5>
				<div class="card-body">
					<form id="contactForm" action="/users/process_support.php" method="post">
						<div class="form-row">
							<div class="form-group col-md-6">
								<div class="form-group">
									<label for="contactFirstName" >Prénom : </label>
									<input type="text" name="contactFirstName" class="form-control" placeholder="Prénom"/>
								</div>
							</div>
							<div class="form-group col-md-6">
								<div class="form-group">
									<label for="contactLastName" >Nom :  </label  >
									<input type="text" name="contactLastName" class="form-control" placeholder="Nom"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="contactMail" >Mail : </label>
							<input type="text" name="contactMail" class="form-control" placeholder="Mail" />
						</div>
						<div class="form-group">
							<label for="contactSubject" > Réclamation : </label>
							<input type="text" name="contactSubject" class="form-control" placeholder="Sujet"/>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="contactText" rows="3" placeholder="Quel est votre réclamation ?"></textarea>
						</div>
						<button name="sendForm" type="submit" class="btn btn-primary">Envoyer</button>
					</div>
				</form>
			</div>
		</div>
		<?php Misc::bottomNavBar("Support"); ?>
	</body>
</html>