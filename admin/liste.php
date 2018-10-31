<?php
	session_start();
	
	include_once('../lib/users.php');
	include_once('../lib/db.php');
	include_once('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/question.php');
	include_once('../lib/visitor.php');
	include_once('../lib/analytics.php');
	
	$db = new Db;   
	$db->connect(true); //Fonctionne
	
	
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

	$quest= new Question($db);
	$questionsList = $quest->getAll();

	$count=0;
	
	
	Misc::genericIcon();
	Misc::genericLogo();
	Misc::genericCss();


?>
<!DOCTYPE html>
<html lang="fr">
	
	<head>
		<title>Gestion des questions - Kouize</title>
		
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
			Misc::topNavbar("Questions");
			Alert::display();
			Misc::logoutModalForm();
		?>
		<div class="container mt-5">
			
			<div class="card" style="background-color: dark;">
				
				<center>
					
					<h1>Liste de questions</h1>
					
					<div>
						
						<a role="button" class="btn btn-warning text-white" href="add-question.php">Ajouter une question</a>
						
						<a role="button" class="btn btn-warning text-white" href="novalidliste.php">Valider les questions utilisateurs</a>
					
					</div>
					
					<br>
					<center>
						<form action="process_search.php" method="POST">
						<div class="col-sm-5">
							<div class="form-group">
								<input name="search" class="form-control" type="text" placeholder="Recherche">
								<input class="form-control btn btn-warning text-white" value="Rechercher" type="submit">
							</div>
						</div>
						</form>
					</center>
					
				</center>
				
			</div>
			
		</div>
		
		<!-- Tableau des questions -->
		
		<div class="container mb-5">
			
			<table class="table table-hover table-sm bg-white">
				
				<!-- Header Tableau -->
				<thead class="thead-light">
					
					<tr>
						
						<th>Question</th>
						<th>Réponse</th>
						<th>Choix 2</th>
						<th>Choix 3</th>
						<th>Choix 4</th>
						<th>Modification</th>
						<th>Suppression</th>
						
					</tr>
					
				</thead>
				
				<tbody>
					
					<!-- Affichage dynamique des cases du tableau -->
					
					<?php
						foreach ($questionsList as $question)
						{
							$count+=1;
					?>
							<tr>
								<td><?php echo $count.'. '.$question['question'] ?></td>
								<td><?= $question['answer'] ?></td>
								<td><?= $question['proposal1'] ?></td>
								<td><?= $question['proposal2'] ?></td>
								<td><?= $question['proposal3'] ?></td>
								<td><a role="button" class="btn btn-info" href="add-question.php?questionId=<?= $question['id'] ?>" >Modifier</a></td>
								<td><button id="<?= $question['id']?>" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete" data-id="<?= $question['id']?>" onclick="return confirmation(this)" >Supprimer</button></td>
							</tr>
					<?php
						} 
					?>
					
				</tbody>
				
			</table>
	
		</div>
			
		<!-- Modal de confirmation de suppression -->
				
		<div class="modal fade" id="modalDelete">
			
			<div class="modal-dialog">
				
				<div class="modal-content">
	
					<!-- Modal Header -->
					
					<div class="modal-header">
						
						 <h4 class="modal-title">Voulez vous vraiment supprimer cette question ?</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
						 
					</div>
	
					<!-- Modal body -->
					
					<div class="modal-body">
						
						<center>
							
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
							<a style="color:#fff" role="button" id="ID_modal-button" class="btn btn-danger" >Confirmer la suppression</a>
							
						</center>
						
					</div>
	
				</div>
				
			</div>
			
		</div>
		<?php
			Misc::bottomNavBar(rien);
		?>
		 
		<!-- Script pour passer l'id à la page delete.php -->
		
		<script>
			$('#modalDelete').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var id_question = button.data('id') // Extract info from data-* attributes
					  
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
				$("#ID_modal-button").attr("href","/admin/process_delete.php?id="+id_question);
			})
		</script>
		
	</body>
	
</html>