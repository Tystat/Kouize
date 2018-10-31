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
	$db->select('users','pseudo','%',$result,'',false);
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	$userList=$result;
	$count=0;
		
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
		<title>Gestion des utilisateurs - Kouize</title>
		<meta name="description" content="Testez Kouize le nouveau jeu original de quizz sur internet !">
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
			Misc::topNavBar('Utilisateurs');
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Alert::display();
		?>
		
		<div class="container mt-5 pt-5 pb-5 text-white">
				
				<table class="table table-hover table-dark">
					
					<thead>
						
						<tr>
							
							<th>Utilisateur</th>
							<th>Adresse mail</th>
							<th>Privilège</th>
							<th>Modifier</th>
							<th></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						<?php
						
						foreach ($userList as $user)
						{
							
							/*-------------------------------------VALEURS DANS OPTION+CREATION DOCUMENT PROCESS ------------------------*/
						?>
							<tr>
								<td><?php echo $count.'. '.$user['pseudo'] ?></td>
								<td><?= $user['mail'] ?></td>
								<td><?php if($user['privilege']==1)echo 'Administrateur'; else echo 'Utilisateur' ?>
						<?php
							if($user['modif_privilege']==1) {
						?>
									<i class="fas fa-redo-alt"></i>
						<?php
							}
						?>
								</td> 
								<td>
									<form method="POST" action="process_userGestion.php?pseudo=<?= $user['pseudo'] ?>">
									<select name="status" class="form-control">
										<option value="1"<?php if($user['privilege']==1)echo "selected";?>>Administrateur</option>
										<option value="0" <?php if($user['privilege']==0)echo "selected";?>>Utilisateur</option>
									</select>
								</td>
								<td><center><button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button></center></td>
								</form>
								<td><center><button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-pseudo="<?=$user['pseudo']?>" data-target="#myModal">Supprimer <i class="fas fa-times"></i></button></center></td>
								</tr>
						<?php
						$count+=1;
						} 
						?>
					</tbody>
				</table>
			
				
				<?php
					Misc::bottomNavBar('Utilisateurs');
				?>
		</div>
		<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <p>Désirez vous réellement supprimer cet utilisateur ?</p>
        </div>
        <div class="modal-footer">
        	<a id="ID_modal-button"><button class="btn btn-danger">Supprimer</button></a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

	<script>
			$('#myModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var pseudo_user = button.data('pseudo') // Extract info from data-* attributes
					  
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
						
				//modal.find('.modal-footer input').val(recipient)
				$("#ID_modal-button").attr("href","process_ban.php?pseudo="+pseudo_user);
			})
	</script>

	</body>
</html>