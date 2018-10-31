<?php 
	session_start();
	include_once ('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/db.php');
	include_once('../lib/player.php');
	include_once("../lib/secure.php");
	include_once('../lib/visitor.php');
	include_once('../lib/analytics.php');
	
	$db=new Db;
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	Secure::post();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<title>Salon - Kouize</title>
		<meta name="description" content="Testez Kouize le nouveau jeu original de quiz sur internet !">
		<?php
			Misc::genericCss();
			Misc::bootstrap();
			Misc::genericIcon();
			Misc::genericLogo();
		?>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
		<script>
		var redirect=false;
		//------------------GESTION DU DEPART D'UN JOUEUR-----------------
			window.onbeforeunload = function leave(){
				//console.log("EvtSources closed");
				evtSourceChat.close();
				evtSourceJoueur.close();
				if (redirect==false)
				{
					//console.log('process_leave executed');
					$.ajax({
					type: "POST",
					url: "process_leave.php?player=<?//=$_SESSION['player']?>&gameId=<?//=$_SESSION['idgame']?>"
				
			})};
			return undefined;
			}
		</script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="../js/amis.js"></script>
	</head>
	<?php
				Analytics::track();
		?>
	<body class="body" >
	
		<?php
			Misc::topNavBar('Jouer');
			Misc::loginModalForm();
			Misc::logoutModalForm();
			Alert::display();
		?>
	
		<div class="container-fluid mt-5 pt-5 pb-5 h-75">
			
			<div style="opacity:0.9;" class="row">
			 
				<div class="col-sm-5">
				  
					<div class="card text-white bg-dark mb-3">
						
						<div class="card-header bg-danger text-center">
							
							 <h4 class="card-title text-center">Joueurs dans le salon <i class="fas fa-gamepad"></i></h4>
							 
						</div>
						
						<div id="test" class="card-body scroll-575pxy">
							
						</div>
						
					</div>
				  
				</div>
				
				<div class="col-sm-5">
					
					<div class="card text-white bg-dark mb-3">
						
						<div class="card-header bg-danger rounded-top">
							
							<h4 class="card-title text-center">Invitez vos amis <i class="fas fa-child"></i></h4>
						
						</div>
						
						<div class="card-body text-center">
							
							Voici votre code de salon
							<br>
							<input class="form-control text-center" readonly id="roomCode" value="<?=$_SESSION['number'] ?>">
							<br>
							<button type="button" data-clipboard-action="copy" data-clipboard-target="#roomCode" class="btn btn-info">Copier dans le presse-papier</button>
							<p>Les autres joueurs doivent choisir "Rejoindre une partie" et rentrer le code ci-dessus afin de vous rejoindre.</p>
							<p>Veuillez ne pas quitter cette page en fermant votre navigateur ou l'onglet, veuillez changer de page ou revenir à l'accueil avant, merci !</p>
						</div>
						
					</div>
					
					<div class="card text-white bg-dark mb-3">
						
						<div class="card-header bg-danger rounded-top">
							
							<h4 class="card-title text-center">Chat <i class="far fa-comments ml-2"></i></h4>
							
						</div>
						
						<div class="card-body">
							
							<div class="scroll-220pxy" id="scrollChatBas">
								
								<div id="afficher"></div>
								
								<script>
									/*function scrollBas() {
										var scrollChatBas = document.getElementById('scrollChatBas');
										scrollChatBas.scrollTop = scrollChatBas.scrollHeight;
									}
									setInterval(scrollBas,300);*/
								</script>
								
							</div>
							
							<form method="post" class="form-inline formChat" >
								
								<div class='row w-100'>
									
									<div class='col-sm'>
										
										<div class="form-group mt-2">
											
											<input autofocus type="text" id="chatSent" name="chatSent" class="chatSent col-sm form-control w-100" class="chatSent">
											
										</div>
										
									</div>
									
									<div class='col-sm-auto'>
										
										<div class="form-group  mt-2">
											
											<button value="submit" type="submit" id="envoi" class="btn btn-primary submit">Envoyer<i class="fab fa-untappd ml-1"></i></button>
											
										</div>
										
										
									</div>
									
								</div>
								
							</form>
							
						</div>
						
					</div>
					
				</div>
				
				<div class="col-sm">
					
				</div>
				
				<div class="col-sm align-self-end text-right">
					
					<?php
					
						if ($_SESSION['playerStatus']==2)
						{
					?>
	
							<div class="card text-white bg-dark mb-3">
								<div class="card-body text-center">
									
									<button type="button" class="btn btn-danger" onclick = "redirection()">Lancer la partie !</button>
								</div>
							</div>
					<?php
					
						}
						
					?>
				
				</div>
			  
			</div>
			
		</div>
		
	<?php
		Misc::bottomNavBar('Accueil');
	?>
	
	<script language="javascript">
	/*	//console.log("début script");
		var evtSourceJoueur = new EventSource("joueur.php?numgame=<?=$_SESSION['idgame']?>")
		evtSourceJoueur.onmessage = function(e) {
			//console.log("msg");
		}
		evtSourceJoueur.onerror = eventSourceErrorFunction;
		var eventSourceErrorFunction = function(event)
		{
			if (event.eventPhase == EventSource.CLOSED) {
				that.eventSource.close();
				//console.log("Event Source Closed");
				} 
		}
		var i;
		
		var count;
		//var pseudoP=[];
		var obj;
	   
		
		evtSourceJoueur.addEventListener("ping", function(e)
		{
			obj = JSON.parse(e.data);
			count = 0;
			$('#test').html('');
			for (i=0;i<obj.length;i++){
			
			if("<?php //echo $_SESSION['player']?>" == obj[i]["pseudo"]){
				count++;
			}
			if(obj[i]["statut"] == 0){
				var nbrejoueurs = obj.length;
				document.location.href = "game.php?id_game=<?php//$_SESSION['number']?>&np="+nbrejoueurs+""; 
			}
			
			//Affichage des joueurs 
			
			if (<?php//$_SESSION['playerStatus']?> == 2)
			{
				$('#test').append('<h5><button id="button" type="button" class="btn btn-danger" onclick="kickPlayer('+i+')"  >X</button> '+ obj[i]["pseudo"]);
				////console.log("j'affiche j1");
				
			}
			else {
				$('#test').append(obj[i]["pseudo"]+ '<br>');
			}             
				
				
			}
			
			if (count==0){ //Si plus dans la bdd redirection
				//console.log("redirection");
				document.location.href = "https://adminkouize-adminkouize.c9users.io/";
			}
			
			
			
		}, false);*/
		
		function redirection(){
		   //console.log("lancement de la partie");
		   redirect=true;
		   $.ajax({
					type: "POST",
					url: "process_jouer.php?numGame="+<?=$_SESSION['idgame']?>+""
			});
		   
		}
				
		
		function kickPlayer(i){ //Ejecter des joueurs
			
		   
			//var nbplay = obj.length-1;
			////console.log(nbplay);
			//var pseudoPl = pseudoP[i];
			////console.log(pseudoPl);
			//console.log(obj.length);
			$.ajax({
					type: "POST",
					url: "process_kickplayer.php?pseudoPlayer="+obj[i]["pseudo"]+""
			});
			
			//document.location.href = "process_kickplayer.php?pseudoPlayer="+obj[i]["pseudo"]+"";
			//console.log("je kick");
			//if(nbplay == 0){
			////console.log("redirection")
			//document.location.href = "https://adminkouize-adminkouize.c9users.io/";
			//}
			}
		
		
		
			 /*------------------------------------Fonctions mini-chat-------------------------------------------*/
			
		$(document).ready(function(){
				
				recupMessages();
				
				$('.formChat').submit(function(){
					var message = $('.chatSent').val();
					$.post('sendMessage.php',{chatSent:message},function(donnees){
						$('.chatSent').val('');
						//console.log("SENT");
					});
					return false;
				});
			
				function recupMessages(){
					$.post("process_chat_receve.php?numgame=<?php$_SESSION['idgame']?>&pseudo=<?php$_SESSION['usr-data']['pseudo']?>",function(data){
						$('#afficher').html(data);
					});
				}
				
				
			
		});
		
	/*	var evtSourceChat = new EventSource("process_chat_receve.php?numgame=<?php//$_SESSION['idgame']?>&pseudo=<?php//
	?>");
		evtSourceChat.onmessage = function(f) {
			
		}
		evtSourceChat.onerror = eventSourceErrorFunction;
		var ii;
		var objet;
	   
		evtSourceChat.addEventListener("ping", function(f)
		{
			objet = JSON.parse(f.data);
			
			$('#afficher').html('');
			
		   

			for (ii=0;ii<objet.length;ii++){
			
				$('#afficher').append(objet[ii]["message_chat"]+'<br>');
			}
			
		}, false);  */
		
			
		
	/*--------------------------------------------GESTION DE LA COPIE---------------------------------------------------*/
				
		new Clipboard('.btn');
				
	</script>
  </body>
  
</html>