<?php

	include_once('users.php');
	include_once('chat.php');
	// Classe pour afficher la charte grphique automatiquement sur toutes les pages 
	$db = new Db;
    $db->connect(true);
	
	
class Misc
{
	// Genere le style Css par default (doit être appelé dans le header)
	
	public static function genericCss()
	{
		 ?>
		 <link rel="stylesheet" href="/css/generic.css">
		 <?php
	}
	
	// Integre les librairies BootStrap (doit être appelé dans le header)
	
	public static function bootstrap()
	{
	 ?> 
	<meta charset="utf-8">
	<meta http-equiv="content-language" content="fr-FR">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0 maximum-scale=1" />
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
	 
	 <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<?php
		
	}
	
	//Génère les icônes pour les boutons
	  
	public static function genericIcon()
	{
	 ?>
		 <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>
	 <?php
	}
	
	 //Génère le logo mettre dans tous les head
	
	public static function genericLogo()
	{
	 ?>
		 <link rel="icon" href="../media/favicon.ico">
	 <?php
	}
	 
	
	
	// Genere la barre de navigation du haut (doit être appelé dans le body)
	
	public static function topNavBar($active)
	{
		
		?>
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-danger">
			<button class="navbar-toggler left" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup1" aria-controls="navbarNavAltMarkup1" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand text-white"><img src="/media/whiteLogo.png" style="height : 20px; margin-bottom: 5px;"></a>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup1">
				<div class="navbar-nav">
					<a class="nav-item nav-link <?= ($active=="Accueil")?'active':''; ?>" href="/"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link <?= ($active=="Jouer")?'active':''; ?>" href="../users/menu_jouer.php"><i class="fas fa-gamepad"></i> Jouer</a>
					<a class="nav-item nav-link <?= ($active=="Règles")?'active':''; ?>" href="../users/regles_du_jeu.php"><i class="fas fa-question-circle"></i> Règles</a>
					<?php
					if (Users::isSuperUser())
					{
					?>
						<a class="nav-item nav-link <?= ($active=="Ajout")?'active':''; ?>" href="../admin/add-question.php"><i class="fas fa-plus-circle"></i> Ajout</a>
					<?php
					}
					else
					{
					?>
						<a class="nav-item nav-link <?= ($active=="Ajout")?'active':''; ?>" href="../users/add-question-user.php"><i class="fas fa-plus-circle"></i> Ajout</a>
					<?php
					}
					?>
					
					<!--AFFICHE LES BOUTONS SEULEMENT SI UN UTILISATEUR EST CONNECTE (VOIR POUR AFFICHER SI ET SEULEMENT SI L'UTILISATEUR CONNECTE EST UN ADMIN)-->
					
					<?php
					if (Users::isLogged())
					{ 
						if (Users::isSuperUser())
						{?>
							<a class="nav-item nav-link <?= ($active=="Questions")?'active':''; ?>" href="../admin/liste.php"><i class="fas fa-file-alt"></i> Questions</a>
							<a class="nav-item nav-link <?= ($active=="Visiteurs")?'active':''; ?>" href="../admin/last_visitors.php"><i class="fas fa-eye"></i> Visiteurs</a>
							<a class="nav-item nav-link <?= ($active=="Utilisateurs")?'active':''; ?>" href="../admin/userGestion.php"><i class="fas fa-users"></i> Utilisateurs</a>
						<?php
						}
						?>
						<a class="nav-item nav-link <?= ($active=="Amis")?'active':''; ?>" onClick="AfficherMasquer()" style="cursor:hand;"><i class="far fa-address-book"></i> Amis</a>
							<script>
							    function AfficherMasquer()
					            {
					                divInfo = document.getElementById('divacacher');
					                if (divInfo.style.visibility == 'hidden')
					                    divInfo.style.visibility = 'visible';
					                else
					                    divInfo.style.visibility = 'hidden';
					                    document.getElementById('divacacherprivate').style.visibility ='hidden';
					            }
					
							</script>
						<?php
					}
					?>
					
					<!--AFFICHE LES BOUTONS SEULEMENT SI UN UTILISATEUR EST CONNECTE (VOIR POUR AFFICHER SI ET SEULEMENT SI L'UTILISATEUR CONNECTE EST UN ADMIN)-->
					
				</div>
			</div>
			
			
			<?php
			
			if (Users::isLogged())
			{ 
			?>
				<div class="dropdown">
					<button type="button" class="btn btn-danger text-warning dropdown-toggle  <?= ($active=="player")?'active':''; ?>" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['usr-data']['pseudo']?></button>
					<div class="dropdown-menu bg-dark">
						<a style ="opacity:0.9;"class="dropdown-item bg-secondary" href="../users/modifUser.php">Modifier mon compte</a>
						<button type="button" style ="opacity:0.9;" class="dropdown-item bg-danger text-white" data-toggle="modal" data-target="#modalDel">Supprimer mon compte</button>
					</div>
				</div>
				
				<button type="button" class="btn btn-dark btn-sm text-white" data-toggle="modal" data-target="#LogoutModal"><span class="d-none d-md-inline">Déconnexion</span> <i class="fas fa-sign-out-alt"></i></button>
			<?php
			}
			else
			{
			?>
				<button type="button" class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#LoginModal"><span class="d-none d-md-inline">Connexion</span> <i class="fa fa-sign-in-alt"></i></button>
				
			<?php
			}?>
		</nav>
		
	<?php
	}
	// Genere la barre de navigation du bas (doit être appelé dans le body)
	  
	public static function bottomNavBar($active)
	{
	?>
	<nav class="navbar navbar-expand fixed-bottom bg-dark text-left py-0">
		<div class="navbar-nav mr-auto">
			<a class="small nav-item nav-link <?= ($active=="Mentions légales")?'active text-white':'text-secondary'; ?>" href="/legal/index.php"><i class="fas fa-bookmark"></i> Mentions légales</a>
			<a class="small nav-item nav-link <?= ($active=="Support")?'active text-white':'text-secondary'; ?>" href="/users/support.php"><i class="fas fa-info-circle"></i> Support</a>
		</div>
	</nav>
		<?php
	}
	
	// Genere le modal du bouton connexion (doit être appelé dans le body)
	
	public static function loginModalForm()
	{
		?>
		  <div id="LoginModal" class="modal fade" role="dialog"> 
			  <div class="modal-dialog">
				  <div class="modal-content">
				  
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal"></button>
						  <center><h4 class="modal-title">Connexion</h4></center>
					  </div>
				  
					  <div class="modal-body">
						  
						  <form action="/users/process_login.php" method="post">
							  <div class="container text-center">
								  <label for="InputEmail">Adresse email :</label>
								  <input autofocus type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Saisir email" name="mail">
								  <label for="InputPassword">Mot de Passe :</label>
								  <input type="password" class="form-control" id="InputPassword" aria-describedby="passwordHelp" placeholder="Saisir mot de passe" name="mdp"><br><br>
								  <input type="submit" class="btn btn-success" name="valConnexion" value="Connexion"><br><br>
								  <a href="/users/inscription.php">Pas encore inscrit ?</a>
							  </div>
						  </form>
						  
					  </div>
				  
					  <div class="modal-footer">
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
					  </div>
			  
				  </div>  <!-- end of modal content -->
			  </div>  <!-- end of modal dialog -->
		  </div>  <!-- end of modal -->
		<?php
	}
	
	public static function updateLogPlayer()
	{
		$etat;
		$player = $_SESSION['usr-data']['pseudo'];
		if (Users::isLogged()){
			$etat=1;
		}
		else{
			$etat=0;
		}
	
		return;	
	}
	
	public static function logoutModalForm()
	{
		?>
		<div id="LogoutModal" class="modal fade" role="dialog"> 
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"></button>
						<center><h4 class="modal-title">Déconnexion</h4></center>
					</div>
					<div class="modal-body">
						<center>Voulez-vous vraiment vous déconnecter ?</center>  
					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-success" data-dismiss="modal" onclick="document.location.href='../users/process_logout.php'">Confirmer</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					</div>
				</div>  <!-- end of modal content -->
			</div>  <!-- end of modal dialog -->
		</div>  <!-- end of modal -->
		
		<div class="modal fade in" id="modalDel" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title ">Etes-vous sûr de vouloir faire cela?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body text-dark">
						Voulez-vous vraiment supprimer votre compte ?<br>
						Vous ne pourrez plus vous connecter avec vos données actuelles, et vous perdrez tous vos scores et résultats enregistrés...<br>
						<center><img src="/media/attention.png" class="rounded " alt="ATTENTION !!!"></center>
					</div> 
					<div class="modal-footer">
						<button type="button" class="btn btn-success btn-block" data-toggle="collapse" data-target="#confirmation">Oui</button>
						<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Non</button>
					</div>
					<div id="confirmation" class="collapse">
						<form action="/users/process_deletecount.php" method="post">
							<div class="container text-center">
								<input autofocus type="email" class="form-control" id="emailsupp" aria-describedby="emailHelp" placeholder="Saisir email" name="mailConf"><br>
								<input type="password" class="form-control" id="passwordsupp" aria-describedby="passwordHelp" placeholder="Saisir mot de passe" name="mdpConf"><br>
								<input type="submit" class="btn btn-success" name="valConfirmation" value="Confirmation"><br><br>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>

		<!----------------------- Recherche de joueurs dans la bdd pour les ajouter ---------------------->
		
		<div id="divacacher" style="visibility:hidden;  width:20%; z-index: 10; height: 100%; position: fixed; top: 0;">

		<nav class="d-none d-md-block sidebar pt-5 ml-2" style="min-height: 100%;">
		<div class="w-100 bg-dark" style="height:100%;opacity: 0.92;">
		<div class="px-2">
		    <br>
		    <br>
		        <form method="POST" action="../users/addFriend.php">
		           <div class="form-group">
		               <input id="recherche" autofocus class="form-control" placeholder="Trouver un ami" type="text" name="search" />
		               <input class="form-control btn btn-primary" value="Ajouter" type="submit"/>
		            </div>
		        </form>
		</div>
		<!----------------------- Liste amis sur le côté ---------------------->
        <?php
        //SLECTION DANS TABLE friends OU friends1 = variable de session de notre pseudo + Afficher sous forme de liste friends 2
        $pseudoJoueur = $_SESSION['usr-data']['pseudo'];
        //$db->select('friends','friend1',$pseudoJoueur,$resultFriends,'OR  friend2 LIKE `'.$pseudoJoueur.'`',false);
        $db->select('friends','friend1',$pseudoJoueur,$resultFriends,"",false);
        
        /* NON FONCTIONNEL */
        //$db->select('friends','friend2',$pseudoJoueur,$resultFriends2,"",false);
        //$resultFriends = array_merge($resultFriends, $resultFriends2);
        
        //SELECT  `friend1` FROM  `friends` WHERE  `friend1` LIKE  '%dylan%'OR  `friend2` LIKE  '%dylan%'
        
        //$db->selectMult('friends',array('friend1','friend2'),array($pseudoJoueur,$pseudoJoueur),$resultFriends,"",false);
        
        $resultFrds = count($resultFriends);
        
       
        
        ?>
		
        <div class="pl-2">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
                
            <h5 class="sidebar-heading d-flex justify-content-between align-items-center mt-4 mb-1 text-light">
                <span>Mes amis <i class="fas fa-child"></i></span>
                <span data-feather="plus-circle"></span>
            </h5>
            
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                  <span data-feather="file-text"></span>

<!-- Le but de cette partie est de créer une liste déroulante avec vos amis-->
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Liste d'amis
						<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  	 <?php  $i=0; 
                  	 		while($i < $resultFrds){ 
                  	 			$fri = $resultFriends[$i]['friend2']; ?>
			                  	<li>
			                		<div><a "nav-link"><?php echo $fri ; ?></a><td><a type="button" id="delFriend" class="btn btn-danger btn-sm ml-2 mr-2" href="../users/process_delfriend.php?friendel=<?= $fri ?>" > Supprimer </a><br><?php
	                            	$i++;?></td> </div>
	                            	
	                            </li>
                  	<?php } ?>
                  	</ul>
                  	</div>
                    <?php /*
                         $i=0;
                        while($i < $resultFrds){

                            $fri = $resultFriends[$i]['friend2'];
                            echo '<i class="fas fa-user"></i> '.$fri; 
                            ?><a type="button" id="delFriend" class="btn btn-danger btn-sm ml-2 mr-2" href="../users/process_delfriend.php?friendel=<?= $fri ?>" > Supprimer </a><br><?php
                            $i++;
                        }
							*/
                    ?>
              </li>
            </ul>
          </div>
        </div>
        
        <div class="card text-white bg-dark mb-3 mx-3" id="divacacherprivate" style="visibility:hidden;">
						<div class="card-header bg-danger rounded-top">
							<h4 id="friendNameDiv" class="card-title text-center"><i class="fas fa-child"></i></h4>
						</div>
						<div class="card-body text-center">
							<script src="https://code.jquery.com/jquery-3.2.1.min.js">
								
								$('.ChatForm').submit(function(){
									var message = $('.SentChat').val();
									$.post('../users/process_sendprivate_chat.php',{SentChat:message},function(donnees){
										$('.SentChat').val('');
									});
									return false;
								});
								
							</script>
							<div id="messageSheet" class="card-body scroll-300pxy" style="overflow=scroll">
							 
						</div>
						<div class="card-footer">
							<form method="post" class="ChatForm">
					                    <center>
										<input autofocus type="text" id="SentChat" name="SentChat" class="SentChat col-md-10 mt-1">
										<button value="submit" type="submit" id="envoi" class="col-md-10 mt-1">Envoyer<i class="fab fa-untappd ml-1"></i></button>
					                    </center>
					        </form>
						</div>
						
		</div>
        </div>
		</nav>
        </div>
       