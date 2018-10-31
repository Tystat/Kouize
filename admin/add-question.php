<?php
	// A FAIRE : 105 CARACT MAX POUR LA QUESTION
	//38 REP
	
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
?>
<!DOCTYPE html>
<html lang="fr">

	<head>
		
		
		<title>Ajout de question - Kouize</title>
		
		<?php 
			Misc::genericCss();
			Misc::bootstrap();
			Misc::genericIcon();
			Misc::genericLogo();
		?>
		
	</head>
	<?php
		Analytics::track();
	?>
	<body>
		<?php
			if (isset($_GET['questionId']))
			{
			$questionDataValue;
			$db->select("questions", "id", $_GET['questionId'], $questionDataValue);
			$questionTextValue=$questionDataValue[0]['question'];
			$questionAnswerValue=$questionDataValue[0]['answer'];
			$questionProposal1Value=$questionDataValue[0]['proposal1'];
			$questionProposal2Value=$questionDataValue[0]['proposal2'];
			$questionProposal3Value=$questionDataValue[0]['proposal3'];
			$questionThemeValue=$questionDataValue[0]['theme'];
			}
			Misc::topNavBar("Ajout"); 
			Misc::logoutModalForm();
			Alert::display();
		?>

		<div class="container mt-4 pt-5 pb-5">
		
			<div class="card">
				<h5 class="card-header">Ajouter une question</h5>
				<div class="card-body">
					<form id="addQuestionForm" action="/admin/process_<?php if(isset($_GET['questionId'])) echo "edit"; else echo "add"; ?>-question.php?questionId=<?= $_GET['questionId'] ?>" method="post">
		
						<div class="form-group">
		
							<label for="questionText">Question (105 caractères maximum): </label>
							<input autofocus type="text" name="questionText" class="form-control" value="<?=$questionTextValue?>" />
		
						</div>
		
						<div class="form-group">
		
							<label for="questionAnswer">Réponse (28 caractères maximum): </label>
							<input type="text" name="questionAnswer" class="form-control" value="<?=$questionAnswerValue?>" />
		
						</div>
		
						<div class="form-group">
		
							<label for="questionProposal1">Choix 1 (28 caractères maximum): </label>
							<input type="text" name="questionProposal1" class="form-control" value="<?=$questionProposal1Value?>" />
		
						</div>
		
						<div class="form-group">
		
							<label for="questionProposal2">Choix 2 (28 caractères maximum): </label>
							<input type="text" name="questionProposal2" class="form-control" value="<?=$questionProposal2Value?>" />
		
						</div>
		
						<div class="form-group">
		
							<label for="questionProposal3">Choix 3 (28 caractères maximum): </label>
							<input type="text" name="questionProposal3" class="form-control" value="<?=$questionProposal3Value?>" />
		
						</div>
		
						<div class="form-group">
		
							<label for="questionTheme">Thème : </label>
							<select class="form-control" name="questionTheme">
								<option value='6' <?php if($questionThemeValue=='6' ) echo "selected";?> >Astronomie</option>
								<option value='2' <?php if($questionThemeValue=='2' ) echo "selected";?> >Cinéma et télévision</option>
								<option value='9' <?php if($questionThemeValue=='9' ) echo "selected";?> >Géographie</option>
								<option value='5' <?php if($questionThemeValue=='5' ) echo "selected";?> >Histoire</option>
								<option value='10' <?php if($questionThemeValue=='10' ) echo "selected";?> >Jeux vidéo</option>
								<option value='8' <?php if($questionThemeValue=='8' ) echo "selected";?> >Littérature</option>
								<option value='11' <?php if($questionThemeValue=='11' ) echo "selected";?> >Musique</option>
								<option value='7' <?php if($questionThemeValue=='7' ) echo "selected";?> >Science du vivant</option>
								<option value='3' <?php if($questionThemeValue=='3' ) echo "selected";?> >Sport</option>
								<option value='4' <?php if($questionThemeValue=='4' ) echo "selected";?> >Technologie</option>
							</select>
						</div>
		
						<button <?php if(isset($_GET['questionId'])) echo 'type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitModal"'; else echo 'type="submit" class="btn btn-primary" form="addQuestionForm"'; ?> >
							<?php
								  if(isset($_GET['questionId']))
									echo "Modifier";
								  else
									echo "Valider";
								?>
						</button>
						<a href='../admin/liste.php'>
							<button type='button' class='btn btn-primary mx-2'>
								Liste
							</button>
						</a>
		
						<input type='hidden' name="questionId" class="form-control" value='<?= $_GET[' questionId '] ?>' />
		
					</form>
				</div>
			</div>
		
		</div>
		
		<!-- POPUP DE VALIDATION -->
		
		<div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="submitModal" aria-hidden="true">
		
			<div class="modal-dialog" role="document">
		
				<div class="modal-content">
		
					<div class="modal-header">
		
						<h5 class="modal-title" id="exampleModalLabel">Veuillez confirmer</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		
							<span aria-hidden="true">&times;</span>
		
						</button>
		
					</div>
		
					<div class="modal-body">
						Voulez vous vraiment modifier cette question ?
					</div>
		
					<div class="modal-footer">
		
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary" form="addQuestionForm">Valider</button>
		
					</div>
		
				</div>
		
			</div>
		
		</div>
		<?php Misc::bottomNavBar("Ajout de questions");  ?>
	</body>
	
</html>