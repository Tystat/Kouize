<?php 
	session_start();
	include_once ('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/visitor.php');
	include_once('../lib/db.php');
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true)
	
?>
<!DOCTYPE html>
<html>
	
	<head>
		<?php
			//visitor::log($db);
			Misc::genericCss();
			Misc::bootstrap();
			Misc::genericIcon();
			Misc::genericLogo();
		?>
		<title>Jouer - Kouize</title>
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
			Misc::topNavBar('Jouer');
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Misc::bottomNavBar('Accueil');
			Alert::display();
		?>
		
		<div class="container-fluid mt-5 pt-5 pb-5">        
		
			<h3 class="text-center text-white" style="color:opacity:1;">
				
			<!--	<b>Jouons à un petit jeu !</b> -->
	
			</h3>
			<div class="mx-auto text-center align-middle">
				<div class="row mt-4 mx-auto"> 
					<div class="col-sm-3 d-flex align-items-stretch ml-auto">
						<div style="opacity:0.9;" class="shadow card px-0 m-0 w-100 mb-3">
							<form action="../users/process_invite.php" method="post">
								<div class="card-header bg-danger text-white"> <h2>Rejoindre une partie</h2></div>
								<div class="card-body text-left">
									<div class="form-group">
										<label class="my-0">Code</label>
										<div class="input-group form-group-lg">
											<input type="text" name="clef" required class="form-control my-0" placeholder="1234">
										</div>
									</div>
									<div class="form-group">
										<label class="my-0">Pseudo</label>
										<input type="text" name="pseudoJoin" required class="form-control my-0" placeholder="" value="<?php echo $_SESSION['usr-data']['pseudo'] ?>">
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" href="#" class="btn btn-dark btn-block btn-lg">J'arrive !</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-3 d-flex align-items-stretch mr-auto">
						<div style="opacity:0.9;" class="shadow card px-0 m-0 w-100 mb-3">
							<form action="../users/process_host.php" method="post">
								<div class="card-header bg-danger text-white"> <h2>Créer une partie</h2></div>
								<div class="card-body text-left">
									<div class="form-group my-auto">
										<br><br>
										<label class="my-0" >Pseudo</label>
										<input type="text" name="pseudoCreate" required class="form-control my-0" placeholder="" value="<?php echo $_SESSION['usr-data']['pseudo'] ?>">
										<br><br>
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" href="#" class="btn btn-dark btn-block btn-lg">C'est parti !</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<h3 class="text-center" style="color:white">
					Voilà notre prototype de jeu !
				</h3>
			</div>
		</div>
	</body>  
</html>