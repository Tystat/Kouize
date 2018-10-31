<?php
	session_start();
	include_once('../lib/db.php');
	include_once('../lib/visitor.php');
	include_once('../lib/users.php');
	include_once('../lib/misc.php');
	include_once('../lib/alert.php');
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true);	
	$db->select('log_visitors','id','%',$result,'ORDER BY timestamp DESC LIMIT 500');
	$ipList=$result;
	
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
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	Misc::genericIcon();
	Misc::genericLogo();
	Misc::genericCss();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
	
		
		<title>Derniers visiteurs - Kouize</title>
		
		<?php 
			Misc::bootstrap();
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
			Misc::topNavbar("Visiteurs");
			Alert::display();
			Misc::logoutModalForm();
		?>

		<div class="container mt-5">
			<div class="card" style="background-color: #e9ecef;">
				<center>
					<h1>Liste des 500 dernières connexions</h1>
				</center>
		
			</div>
		</div>
		<div class="container mb-5 mx-3">
			<table class="table table-hover table-sm bg-white">
		
				<!-- Header Tableau -->
				<thead class="thead-light">
					<tr>
						<th>Adresse IP</th>
						<th>IP forward</th>
						<th>IP client</th>
						<th>page</th>
						<th>heure</th>
					</tr>
				</thead>
				<tbody>
		
					<!-- Affichage dynamique des cases du tableau -->
		
					<?php
								foreach ($ipList as $champ)
								{
									$count+=1;
								?>
						<tr style="500px;">
							
							<td>
								<?php echo $count.'. '.$champ['ip_addr'] ?>
							</td>
							
							<td>
								<?= $champ['ip_forw'] ?>
							</td>
							
							<td>
								<?= $champ['client'] ?>
							</td>
							
							<td>
								<?= $champ['uri'] ?>
							</td>
							
							<td>
								<?= $champ['timestamp'] ?>
							</td>
							
						</tr>
						<?php
								} 
							?>
		
				</tbody>
			</table>
		</div>
		<?php Misc::bottomNavBar(rien); ?>
	</body>
</html>