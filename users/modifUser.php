<?php 
	session_start();
	include_once('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/visitor.php');
	include_once('../lib/db.php');
	include_once('../lib/analytics.php');
	
	$db =new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	$db->select('users','mail',$mail,$result);
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
		<meta name="description" content="Testez Kouize le nouveau jeu original de quiz sur internet !">
		<title><?php echo $_SESSION['usr-data']['pseudo'] ?> - Kouize</title>
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
			Misc::topNavBar('player');
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Alert::display();
		?>
		<center>
			
			<div class="container-fluid mt-5 pt-5 pb-5 text-white">
				
				<h2><b>Votre compte</b></h2>
				
				<p>Vous pouvez modifier vos données ici !</p>     
				
				<form action="../users/process_modifUser.php" method="post">
					
					<table style="opacity:0.9;" class="table table-dark table-hover table-bordered rounded">
						
						<thead>
							
							<tr>
								<th></th>
								<th>Actuelle</th>
								<th>Nouveau</th>
							</tr>
							
						</thead>
						
						<tbody>
							
							<tr>
								<td>Prénom</td>
								<td><?php echo $_SESSION['usr-data']['firstname'] ?></td>
								<td><input type="text" name="modifFirstname" id="modiffirstname" class="form-control" placeholder="Prénom"/></td>
							</tr>
							<tr>
								<td>Nom</td>
								<td><?php echo $_SESSION['usr-data']['lastname'] ?></td>
								<td><input type="text" name="modifLastname" id="modiflastname" class="form-control" placeholder="Nom"/></td>
							</tr>
							<tr>
								<td>Adresse mail</td>
								<td><?php echo $_SESSION['usr-data']['mail'] ?></td>
								<td><input type="mail" name="modifMail" id="modifmail" class="form-control" placeholder="Adresse mail"/></td>
							</tr>
							<tr>
								<td>Pseudo</td>
								<td><?php echo $_SESSION['usr-data']['pseudo'] ?></td>
								<td><input type="text" name="modifPseudo" id="modifpseudo" class="form-control" placeholder="Pseudo"/></td>
							</tr>
							<tr>
								
								<td>Privilège *</td>
								<td>
									<?php 
									if($_SESSION['usr-isSuperUser']!=1)
									{
										echo "Utilisateur";
									}
									else
									{
										echo "Administrateur";
									}
									
									
									
									if($_SESSION['usr-data']['modif_privilege']==1) {
									   ?>
									   <i class="fas fa-redo-alt"></i>
									   <?php
									}
									?>
								</td>
								
								<td>
									
									<select name="modifPrivilege" class="form-control">
										
										 <option value="1"<?php if($_SESSION['usr-data']['privilege']==1)echo "selected";?>>Administrateur</option>
										 <option value="0"<?php if($_SESSION['usr-data']['privilege']==0)echo "selected";?>>Utilisateur</option>
										 
									</select>
							   
								</td>
								
							</tr>
							
						</tbody>
						
					</table>
					
					<p>Vous pouvez modifier votre mot de passe ici !</p>
					
					<table style="opacity:0.9;" class="table table-dark table-hover table-bordered">
						
						<thead>
							
							<tr>
								
								<th></th>
								<th>Nouveau mot de passe</th>
								<th>Confirmer votre mot de passe</th>
								
							</tr>
							
						</thead>
						
						<tbody>
							
							<tr>
								
								<td>Mot de passe **</td>
								<td><input type="password" name="modifPassword1" id="modifpassword1" class="form-control" placeholder="Nouveau mot de passe"/></td>
								<td><input type="password" name="modifPassword2" id="modifpassword2" class="form-control" placeholder="Confirmer nouveau mot de passe"/></td>
								
							</tr>
							
						</tbody>
						
					</table>
					
					<button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#modif"><span class="d-none d-md-inline">Modifier</span></button>
					
					<div id="modif" class="collapse">
						
						<div class="container-sm text-center">
							
							<br><input type="password" class="form-control text-center" id="passwordmodif" aria-describedby="passwordHelp" placeholder="Mot de passe actuel" name="mdpConfModif"><br>
							
							<input type="submit" class="btn btn-primary btn-block" name="valModifier" value="Modifier mes données">
							
						</div>
						
					</div>
					
					<br>
					<br>
					<p>* votre privilège ne sera pas modifié mais les administrateurs traiteront votre demande et jugeront le mérite et l'utilité de la modification.</p>
					<p>** vous devrez entrer 2 fois votre nouveau mot de passe pour pouvoir le modifier.</p>
					
				</form>
				
			</div>
			
		</center>
		
		<?php
			Misc::bottomNavBar('');
		?>
		
	</body>
  
</html>