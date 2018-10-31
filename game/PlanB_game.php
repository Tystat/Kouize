<?php
	session_start();
	include_once('../lib/misc.php');
	include_once("../lib/db.php");
	include_once('../lib/question.php');
	
	$db=new Db;
	$db->connect(true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Jouer - Kouize</title>
		
	<?php 
		Misc::bootstrap();
		Misc::genericCss();
	?>
	
	<style type="text/css">

		.left {
			float: left;
			margin: 0;
			padding: 0;
		}
		.zoom:hover {
		-ms-transform: scale(1.1); /* IE 9 */
		-webkit-transform: scale(1.1); /* Safari 3-8 */
		transform: scale(1.1); 
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="../js/amis.js"></script>
</head>

<body class= "bg-secondary wmax-960">
	<?php
		Misc::topNavbar("Jouer");
		Misc::logoutModalForm();
		Misc::genericIcon();
		Misc::genericCss();
		Misc::bootstrap();
		Misc::genericLogo();
		$np=$_GET['np']; $np=1;
	?>
	
	<center>
		<div class ="mt-5">
			<img style="height:144px; width:256px;" src="../../media/logo.gif"></img>
		</div>
	</center>
	
		<!-- Modal principal du jeu -->
		<div id="kouizeModal" class="modal fade" role="dialog" data-controls-modal="kouizeModal" data-backdrop="static" data-keyboard="false"> 
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="rounded bg-light wmax-960">
						
						<div class="modal-header text-light container mx-auto bg-dark py-4 text-center">
							<h1 class="display-5" id="quest"></h1>
						</div>
						
						<!-- Progress Bar -->
						<div class="progress">
							<div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="30" style="width: 0%">
							</div>
						</div>
						
						<div class="containeralea">
						<div class="modal-body row mx-auto px-5 py-1 ">
							<div class="col-sm order-1 order-sm-2 mx-auto my-1 lead rounded ">
								
								<div class="btn-group btn-group-toggle d-block" data-toggle="buttons">
									<div class="container my-5 text-center">
										<button type="button" id="endTime1" class="btn-answer zoom btn btn-block btn-danger"><b></b></button>
									</div>
												
									<div class="container my-5 text-center">
										<button type="button" id="endTime2" class="btn-answer zoom btn btn-block btn-danger"><b></b></button>
									</div>
												
									<div class="container my-5 text-center">
										<button type="button" id="endTime3" class="btn-answer zoom btn btn-block btn-danger"><b></b></button>
									</div>
												
									<div class="container my-5 text-center">
										<button type="button" id="endTime4" class="btn-answer zoom btn btn-block btn-danger"><b></b></button>
									</div>
								</div>

							</div>
							
							<div class="col-sm order-2 order-sm-1">
							</div>
							<div class="col-sm order-3 order-sm-3">

							</div>
							
							</div>
							
						</container>
					</div>
				</div>  <!-- end of modal content -->
			</div>  <!-- end of modal dialog -->
		</div>  <!-- end of modal -->
	</div>
	
	<script>

		var place = 
		["1254","143","1","0",//1
		"1120","230","2","0",//2
		"995","280","2","0",//3
		"875","330","2","0",//4
		"765","288","1","0",//5
		"640","210","1","0",//6
		"520","120","1","0",//7
		"380","200","2","0",//8
		"260","250","2","0",//9
		"120","290","2","0",//10
		"250","340","3","0",//11
		"110","410","2","0",//12
		"230","470","3","0",//13
		"340","550","3","0",//14
		"465","575","3","0",//15
		"570","655","3","0",//16
		"685","685","3","0",//17
		"810","720","3","0",//18
		"930","680","4","0",//19
		"1050","640","4","0",//20
		"1160","560","4","0",//21
		"1265","650","3","0",//22
		"1390","695","3","0",//23
		"1250","710","2","0",//24
		"1130","780","2","0",//25
		"1250","870","3","0",//26
		"1380","925","3","0",//27
		"1500","880","4","0",//28
		"1615","835","4","0",//29
		"1750","735","4","0"];//30
		
		var nbdep1;
		var s1=-3;
		var caseavance;
		
		//à ne pas modifier
		var s1=-3;
		var i=0;
		var cpt=0;
		var sync=1;//0 reculer, 1 avancer
		
		var stateback='init';
		var nbquest=0;
		var questjson;
		var nbPtsQuest; //VARIABLE PTS A UTILISER
		
		function randomize(){
			var collection = $("div.containeralea div").get();
			collection.sort(function() {
				return Math.random()*20 > 5 ? 1 : -1;
			});
			$.each(collection,function(i,el) {
				$(el).appendTo( $(el).parent() );
			});
		}
		$(document).ready(randomize());
		
		function getQuest(){
			//console.log("Getting Questions");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var obj = JSON.parse(this.responseText);
					questjson = JSON.parse(obj);
					console.log(questjson);
					}
			}
			xmlhttp.open("GET", "process_questions.php?numgame=<?=$_SESSION['codegame']?>", true);
			xmlhttp.send();
		}
			
		function getState(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
					var statut= JSON.parse(this.responseText);
					if(statut['phase']!=stateback)
					{
						if(statut['statut']==3){
							document.location.href = "results.php"; // redirection lors de la fin de partie (30 pts)
						}
						stateback=statut['phase'];
						if(stateback=='quest')
						{
							var good = parseInt(questjson[nbquest+1]['countgood']);
							var bad = parseInt(questjson[nbquest+1]['countbad']);
							
							var ratio = good / (good+bad);
							
							if(ratio < 0.167){
								nbPtsQuest = 6;
							}
							else if(ratio < 0.334){
								nbPtsQuest = 5;
							}
							else if(ratio < 0.501){
								nbPtsQuest = 4;
							}
							else if(ratio < 0.667){
								nbPtsQuest = 3;
							}
							else if(ratio < 0.834){
								nbPtsQuest = 2;
							}
							else{
								nbPtsQuest = 1;
							}
							
							nbquest=statut['numquest'];
							randomize();
							$('#quest').html('');
							$('#quest').append(questjson[nbquest]['question']," (",nbPtsQuest," pts)");
							//Changement des réponses du modal
							$('#endTime1').html('');
							$('#endTime1').append(questjson[nbquest]['answer']);
							$('#endTime2').html('');
							$('#endTime2').append(questjson[nbquest]['proposal1']);
							$('#endTime3').html('');
							$('#endTime3').append(questjson[nbquest]['proposal2']);
							$('#endTime4').html('');
							$('#endTime4').append(questjson[nbquest]['proposal3']);
							//Affichage du modal
							$('#kouizeModal').modal('show');
							setTimeout(timerButton, 10000);
						}
						if(stateback=='anim')
						{
							$('#kouizeModal').modal('hide');
							
							//MOUVEMENT ----------------------------------------------------------------------------------------------------
							getScores();
							console.log(caseavance);
							/*
							nbdep1=caseavance;
							var i;
							
							for (i = 1; i <= nbdep1*2; i=i+2){
								
								if ($("#endTime1").hasClass("selectQuest")){
									s1=s1+2;
									$("#Red").animate({left:(((place[s1-1]-40)*0.824479)/900*700)+'px',top:((((place[s1]-120)*0.824479)/900*700)-218)+'px'}, "slow");
									caseavance=0;
								}
							}
							*/
							
							var dep = caseavance; //Le nombre de cases du déplacement du personnage
							//var dep = deplacement -1;
							
							
							
								if ($("#endTime1").hasClass("selectQuest")){				
									var time = setInterval(function(){
									
									if (sync==1){
									s1=s1+4;
									}	
									else if (sync==0){
									s1=s1-4;
									}
									else if (sync == 3){
										s1=s1;
									}
									
									$("#Red").animate({left:(((place[s1-1]-40)*0.824479)/900*700)+'px',top:((((place[s1]-120)*0.824479)/900*700)-218)+'px'}, "fast", function(){
										console.log("sync : "+sync);
									
									
								
									if(place[s1+5]==2){
									
										document.getElementById("Red").setAttribute("src", "/media/tmpjeu/NinjaRougeVues/FrontLeft.png");
										//console.log("frontLeft");
										
									
										
									}
									else if (place[s1+5]==3){
									
										document.getElementById("Red").setAttribute("src", "/media/tmpjeu/NinjaRougeVues/FrontRight.png");
										//console.log("frontRigth");
										
									
										
									}
									else if (place[s1+5]==1){
									
										document.getElementById("Red").setAttribute("src", "/media/tmpjeu/NinjaRougeVues/BackLeft.png");
										//console.log("backLeft");
										
									
										
									}
									else if (place[s1+5]==4){
									
										document.getElementById("Red").setAttribute("src", "/media/tmpjeu/NinjaRougeVues/BackRight.png");
										//console.log("backRight");
										
										
									}
									
									
									if(cpt >= (dep-1) ){
										
										
										if((place[s1 + 6]) == 1 && (sync != 3) ){
										console.log("coffre");
										var ran = Math.floor((Math.random() * 2) + 1);
										if (ran == 1) 
										{
											
										
										 sync = 1;
										 cpt = cpt - bonus();	
										 console.log("cpt = " + cpt);
											
										}
										if (ran == 2)
										{
										 
										 sync = 0;
										 
										 if (malus() == 20){	
										 console.log("block");
										 sync = 3;
										 clearInterval(time);
										 }else{
										 
										
										 cpt = cpt + malus();	
										 console.log("cpt = " + cpt);
										
										 }
										}
										}else{
										console.log("pas de coffre");
										clearInterval(time);
										cpt = 0;
										sync = 1;
										}
									}else{
										cpt++;
									}
									
							
									});
									
									
								
							}, 500);
							
							caseavance=0;
						}
									
							document.getElementById("endTime1").disabled = false;
							document.getElementById("endTime2").disabled = false;
							document.getElementById("endTime3").disabled = false;
							document.getElementById("endTime4").disabled = false;
								
							$("#endTime1").removeClass("selectQuest");
							$("#endTime2").removeClass("selectQuest");
							$("#endTime3").removeClass("selectQuest");
							$("#endTime4").removeClass("selectQuest");
								
							$("#endTime1").removeClass("btn-warning");
							$("#endTime1").removeClass("btn-secondary");
							$("#endTime1").removeClass("btn-success");
							$("#endTime2").removeClass("btn-warning");
							$("#endTime2").removeClass("btn-secondary");
							$("#endTime2").removeClass("btn-success");
							$("#endTime3").removeClass("btn-warning");
							$("#endTime3").removeClass("btn-secondary");
							$("#endTime3").removeClass("btn-success");
							$("#endTime4").removeClass("btn-warning");
							$("#endTime4").removeClass("btn-secondary");
							$("#endTime4").removeClass("btn-success");
							
							$("#endTime1").addClass("btn-danger");
							$("#endTime2").addClass("btn-danger");
							$("#endTime3").addClass("btn-danger");
							$("#endTime4").addClass("btn-danger");
						}
					}
				}
			}
			xmlhttp.open("GET", "timecheck.php?numgame=<?=$_SESSION['codegame']?>&id=<?=$_SESSION['idgame']?>&pseudo=<?=$_SESSION['player']?>", true);
			xmlhttp.send();
		}
		
		function getScores(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var obj = JSON.parse(this.responseText);
					scorejson = obj.sort(function (a, b) {
						return b.score - a.score;
					});
					console.log(scorejson);
					document.getElementById("result").innerHTML ='';
					var i=0;
					scorejson.forEach(function(element) {
						i++;
						document.getElementById("result").innerHTML += '<div class="col"><b>'+i+'.</b></div><div class="col-4 cell-full cell-ellipsis"><b>'+element.pseudo+'</b></div><div class="col">'+element.score+'pts</div><div class="col-4"><div class="progress"><div id="progressBarScore" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: '+(element.score*(10/3))+'%"></div></div></div><div class="w-100"></div>';
						 if (element.pseudo=='<?=$_SESSION['player']?>')
							caseavance=element.caseavance;
					});
					}
				}
			xmlhttp.open("GET", "../lib/gamestate.php?id=<?=$_SESSION['idgame']?>", true);
			xmlhttp.send();
		}
			
		$("#kouizeModal").on('show.bs.modal', function () {
	
			$(document).ready(function(){
				
				var timeInit = new Date(); 
				var realTime = timeInit.getTime();
				
				var downloadTimer = setInterval(myTimer,90);
				var timeLeft = 0;           
				var pas =90;
				
				function myTimer() {
					var time = new Date();    
					var mesureTime = time.getTime();
	
					timeInit.setTime(realTime+pas);
	
					var delta = (mesureTime-timeInit)/90;
					delta = Math.round(delta);
	
					if (delta>0)
						$('#progressBar').css("width", (timeLeft + delta).toString() + "%");
					else
						$('#progressBar').css("width", timeLeft.toString() + "%");
	
					timeLeft= timeLeft+1;
					if(timeLeft > 100)
						{
							clearInterval(downloadTimer);
						}
					pas = pas + 90;
				}
			});
		});

		$(".btn-answer").on( "click", function() {
			$("#endTime1").removeClass("btn-warning");
			$("#endTime2").removeClass("btn-warning");
			$("#endTime3").removeClass("btn-warning");
			$("#endTime4").removeClass("btn-warning");
			
			$("#endTime1").removeClass("selectQuest");
			$("#endTime2").removeClass("selectQuest");
			$("#endTime3").removeClass("selectQuest");
			$("#endTime4").removeClass("selectQuest");
			
			$("#endTime1").addClass("btn-danger");
			$("#endTime2").addClass("btn-danger");
			$("#endTime3").addClass("btn-danger");
			$("#endTime4").addClass("btn-danger");
			
			$($(this)).removeClass("btn-danger");
			$($(this)).addClass("btn-warning");
			$($(this)).addClass("selectQuest");
		});

		function timerButton() {
			document.getElementById("endTime1").disabled = true;
			document.getElementById("endTime2").disabled = true;
			document.getElementById("endTime3").disabled = true;
			document.getElementById("endTime4").disabled = true;
		// BONNE REPONSE	
			$("#endTime1").removeClass("btn-danger");
			$("#endTime1").removeClass("btn-warning");
			$("#endTime1").addClass("btn-success");
			
		//AUTRE REPONSE
			$("#endTime2").removeClass("btn-danger");
			$("#endTime3").removeClass("btn-danger");
			$("#endTime4").removeClass("btn-danger");
			$("#endTime2").addClass("btn-secondary");
			$("#endTime3").addClass("btn-secondary");
			$("#endTime4").addClass("btn-secondary");
			
			if($("#endTime1").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['answer']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=1&pts='+nbPtsQuest
				});
				//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop1+"&quest="+obj.question+"&goodAnswer="+true;
			}
				
			else if($("#endTime2").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['proposal1']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
				//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop2+"&quest="+obj.question;
			}
				
			else if($("#endTime3").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['proposal2']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
				//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop3+"&quest="+obj.question;
			}
				
			else if($("#endTime4").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswer.php?updQuestAns='+questjson[nbquest]['proposal3']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
				//window.location = "/game/collectAnswer.php?updQuestAns="+obj.prop4+"&quest="+obj.question;
			}
			else{
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswer.php?updQuestAns=NULL&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
			}
		}
		$(document).ready(function()
		{
			$("#myBtn").click(function()
			{
				$("#kouizeModal").modal({backdrop: false});
			});
		});

		getQuest();
		setInterval(getState, 4000);
	
	</script>

	<?php
		Misc::bottomNavBar(" ");
	?>

	<!-- MODAL PROGRESSION JOUEURS-->
			<div class="mt-5 mx-auto" style="width: 70%; min-height: 60%;">
				<div class="mt-5">
					<div class="card text-white bg-dark mt-5">
									
						<div class="card-header text-center bg-warning text-dark"><b>Progression des joueurs </b>
						</div>
											
						<div class="card-body scroll-575pxy">

							<div class="container">
								<div class="row" id = "result">
									<div class="col"><b></b></div>
										<div class="col-5 cell-full cell-ellipsis"></div>
											<div class="col"></div>
												<div class="col-3">
													<div class="progress">
														<div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
														</div>
													</div>
												</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
</body>
</html>
