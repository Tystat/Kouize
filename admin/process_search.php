<?php
session_start();

    include_once('../lib/users.php');
	include_once('../lib/db.php');
	include_once('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/question.php');
	include_once('../lib/visitor.php');
	include_once('../lib/analytics.php');

    $db= new Db;
    $db->connect(true);
    
    visitor::log($db);	// enregistre l'ip dans la base de données
    
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
	
	
	$keyword=$_POST['search'];
	
	$db->select('questions','question','%'.$keyword.'%',$result);
	$count=0;
	foreach ($result as $found){
	    
	    $count=$count+1;
	}
	Misc::genericIcon();
	Misc::genericLogo();
	Misc::genericCss();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="content-language" content="fr-FR">
		
		<title>Résultat de votre recherche - Kouize</title>
		
		<?php 
			Misc::bootstrap();
		?>
    </head>
    <?php
		Analytics::track();
	?>
    <body>
        <?php
			Misc::topNavbar("Questions");
			Alert::display();
			Misc::logoutModalForm();
		?>
        <div class="container mb-5 mt-5">
			
			<table class="table table-hover table-sm bg-white">
				
				<!-- Header Tableau -->
				<thead class="thead-light">
					
					<tr>
						<th>Question</th>
						<th>Id</th>
					</tr>
					
				</thead>
				
				<tbody>
					
					<!-- Affichage dynamique des cases du tableau -->
					
					<?php
					$count=0;
						foreach ($result as $found)
						{
							$count+=1;
					?>
							<tr>
								<td><?php echo $count.'. '.$found['question'] ?></td>
								<td><?php echo $found['id'] ?></td>
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