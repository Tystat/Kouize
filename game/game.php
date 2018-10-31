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
	<meta http-equiv="content-language" content="fr-FR">
	
	<title>Jouer - Kouize</title>
		
	<?php 
		Misc::bootstrap();
		Misc::genericCss();
	?>
	
	<style type="text/css">
		/*Insertion plateu de jeu avec les dimensions*/ 
		#jeu
		{
			width: 1245px;
			height: 700px;
			margin-left: auto;
			margin-right: auto;
			border: 2px black solid;
			background: url('../media/plateauERCoffre.png');

		}
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
		
		#stats
		{
			width: fit-content;
			display: inline-block;
		}
		
	</style>
		<link rel="stylesheet" href="../js/jquery-ui.css">
        
        <script type="text/javascript" src="../js/amis.js"></script>
</head>

<body class= "bg-secondary wmax-960">
	<?php
		Misc::topNavbar("Jouer");
		Misc::bootstrap();
		Misc::logoutModalForm();
		Misc::genericIcon();
		Misc::genericCss();
		Misc::genericLogo();
		$np=$_GET['np']; $np=1;
	?>
	<div class="row" >
    	<div class="row-sm-2" style="display: flex; flex-direction: column;">
		<br><br><br><br><br>
			<div class ="mt-3" style="display: flex; flex-direction: column; width : 256px;z-index: 1000;">
					<img style="height:144px; width:256px;" class = "left"  src="../../media/logo.gif"></img>
					<button id="show" type="button" style="opacity:0.9;" class="btn btn-dark btn text-white mx-5" data-toggle="modal" data-target="#modalStats">
						<div><b>Stats Partie</b></div>
					</button>
					
						<div class="bg-dark text-white mx-auto"  id="info"></div>
			</div>
		
		</div>
		<div class="row-sm-4">
			<div id="jeu" style="width: 1245px;height: 700px;">
				<img id="Red" src="../media/NinjaRougeVues/BackLeft.png" style="top: 80px;left: 853px;position: relative;z-index: 200;">
			</div>
		</div>
		
	</div>

			<!--<div id="jeu" style="width: 1245px;height: 700px;">
				 logo  + button modal stats
				<div class ="mt-5" style="display: flex; flex-direction: column; width : 256px;z-index: 1000;">
					<img style="height:144px; width:256px;" class = "left"  src="../../media/logo.gif"></img>
					<button type="button" style="opacity:0.9;" class="btn btn-dark btn text-white mx-5"  data-toggle="modal" data-target="#modalStats"><div><b>Stats Partie</b></div>
					</button>
				</div>
					Insertion des ninjas avec les positions initiales 
						<img id="Red" src="../media/NinjaRougeVues/BackLeft.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">-->

					
					<!--<?php //}else if ($np==2){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
					<?php //}else if ($np==3){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
					<?php //}else if ($np==4){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php //}else if ($np==5){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange2" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php //}else if ($np==6){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange2" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green2" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php //}?>-->
			</div>
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
	
		// tableau de coordonnée
		/*var place = 
			["1254","143",//1
			"1120","230",//2
			"995","280",//3
			"875","330",//4
			"765","288",//5
			"640","210",//6
			"520","120",//7
			"380","200",//8
			"260","250",//9
			"120","290",//10
			"250","340",//11
			"110","410",//12
			"230","470",//13
			"340","550",//14
			"465","575",//15
			"570","655",//16
			"685","685",//17
			"810","720",//18
			"930","680",//19
			"1050","640",//20
			"1160","560",//21
			"1265","650",//22
			"1390","695",//23
			"1250","710",//24
			"1130","780",//25
			"1250","870",//26
			"1380","925",//27
			"1500","880",//28
			"1615","835",//29
			"1745","735"];//30
		*/   //LE TABLEAU BONUS MALUS ORIENTION
		var place = 
		["1254","143","1","0",//1
		"1120","230","2","0",//2
		"995","280","2","0",//3
		"875","330","2","1",//4
		"765","288","1","0",//5
		"640","210","1","0",//6
		"520","120","1","0",//7
		"380","200","2","1",//8
		"260","250","2","0",//9
		"120","290","2","0",//10
		"250","340","3","0",//11
		"110","410","2","0",//12
		"230","470","3","0",//13
		"340","550","3","1",//14
		"465","575","3","0",//15
		"570","655","3","0",//16
		"685","685","3","1",//17
		"810","720","3","0",//18
		"930","680","4","0",//19
		"1050","640","4","0",//20
		"1160","560","4","0",//21
		"1265","650","3","1",//22
		"1390","695","3","0",//23
		"1250","710","2","0",//24
		"1130","780","2","0",//25
		"1250","870","3","0",//26
		"1380","925","3","0",//27
		"1500","880","4","0",//28
		"1615","835","4","1",//29
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
		var depbonus=0;
		var depmalus=0;
		var nbPts=0; 
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
					
					}
			}
			xmlhttp.open("GET", "process_questions.php?numgame=<?=$_SESSION['codegame']?>", true);
			xmlhttp.send();
		}
			
		function getState(){
			getScores();
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
							getScores();
						}
						if(stateback=='anim')
						{
							$('#kouizeModal').modal('hide');
							
							//MOUVEMENT ----------------------------------------------------------------------------------------------------
							getScores();
						
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
							
							var dep = nbPtsQuest; //Le nombre de cases du déplacement du personnage							//var dep = deplacement -1;
							//console.log("nb case : "+dep);
							
							
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
									
									$("#Red").animate({left:(((place[s1-1]-40)*0.824479)/900*700)+'px',top:((((place[s1]-120)*0.824479)/900*700)+20)+'px'}, "fast", function(){
										
									if(place[s1+5]==2){
									
										document.getElementById("Red").setAttribute("src", "/media/NinjaRougeVues/FrontLeft.png");

									}
									else if (place[s1+5]==3){
									
										document.getElementById("Red").setAttribute("src", "/media/NinjaRougeVues/FrontRight.png");
									
									}
									else if (place[s1+5]==1){
									
										document.getElementById("Red").setAttribute("src", "/media/NinjaRougeVues/BackLeft.png");
	
									}
									else if (place[s1+5]==4){
									
										document.getElementById("Red").setAttribute("src", "/media/NinjaRougeVues/BackRight.png");
		
									}

									if(cpt >= (dep-1) )
									{
										
										if((place[s1 + 2]) == 1 && (sync != 3) ){
										//console.log("coffre");
										var ran = Math.floor((Math.random() * 2) + 1);
										if (ran == 1) 
										{
										
										 sync = 1;
										 depbonus = bonus();
										 cpt = cpt - depbonus +1;	
										 //console.log("cpt = " + cpt);
										 depmalus = 0;
										}
										else if (ran == 2)
										{
										 
										 sync = 0;
										 depmalus = malus();
										 if (depmalus == 20){	
										 //console.log("block");
										 sync = 3;
										 clearInterval(time);
										 depmalus = 0;
										 }else{
										 
										 
										 cpt = cpt + depmalus + 1;	
										 //console.log("cpt = " + cpt);
										 depbonus = 0;
										 }
										}
										$.ajax({
											type: 'GET',
											url : '../game/bonusmalus.php?idgame=<?=$_SESSION['idgame']?>&pseudo=<?=$_SESSION['player']?>&pts1='+(parseInt(depmalus)+parseInt(depbonus))
										});
										}else{
										clearInterval(time);
										cpt = 0;
										sync = 1;
									
										}
									}else{
										cpt++;
									}

								});
							
							}, 500);

							//caseavance=0;
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
					//console.log(this.responseText);
					var obj = JSON.parse(this.responseText);
					scorejson = obj.sort(function (a, b) {
						return b.score - a.score;
					});
					//console.log(scorejson);
					document.getElementById("result").innerHTML ='';
					var i=0;
					var scores;
					scorejson.forEach(function(element) {
						i++;
						
						//console.log("DEPMALUS : " +depmalus);
						//console.log("DEPBONUS : " +depbonus);
						scores =parseInt(element.score) + depmalus + depbonus;
						nbPts = parseInt(nbPtsQuest) + depmalus + depbonus;
					
						//console.log("nb de pts avec bn");
						//scores = parseInt(scores);
						//console.log(nbPts);

						
		
						document.getElementById("result").innerHTML += '<div class="col-1"><b>'+i+'.</b></div><div class="col-4 cell-full cell-ellipsis" style="white-space: nowrap;overflow: hidden;"><b>'+element.pseudo+' </b></div><div class="col-3">'+element.score+'pts</div><div class="col-3"><div class="progress"><div id="progressBarScore" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: '+(element.score*(10/3))+'%"></div></div></div><div class="w-100"></div>';
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
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['answer']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=1&pts='+ nbPtsQuest
				});
			}
				
			else if($("#endTime2").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['proposal1']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
			}
				
			else if($("#endTime3").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswers.php?updQuestAns='+questjson[nbquest]['proposal2']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
			}
				
			else if($("#endTime4").hasClass("selectQuest")){
				$.ajax({
					type: 'GET',
					url : '../game/collectAnswer.php?updQuestAns='+questjson[nbquest]['proposal3']+'&quest='+questjson[nbquest]['question']+'&goodAnswer=0'
				});
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


		
		
		getScores();
		
		getQuest();
		setInterval(getState, 4000);

	//FONCTION BONUS/MALUS
		
	function bonus(){
		var ran = Math.floor((Math.random() * 6) + 1);
		var deplacement = 0;
		if(ran <= 3){
			//console.log("bonus 1 ");
			affiche("Vous avancez d'une case");
			deplacement ++;
			
		}
		if(ran > 3 && ran < 6){
			//console.log("bonus 2 ");
			affiche("Vous avancez de deux cases");
			deplacement = deplacement +2;
	
		}
		if(ran == 6){
			//console.log("bonus 3 ");
			affiche("Vous avancez de trois cases");
			deplacement = deplacement + 3;

		}
	
		return (deplacement);
		
	}
	function malus(){
		var ran = Math.floor((Math.random() * 8) + 1);
		var deplacement = 0;
		if(ran <= 3){
		    //console.log("malus 1 ");
		    affiche("Vous reculez d'une case");
		    deplacement--;
		   
		}
	    if(ran > 3 && ran < 6){
	     	//console.log("malus 2 ");
	     	affiche("Vous reculez de deux cases");
	     	deplacement=deplacement-2;
	     	
		}
		if(ran >=6 && ran <=7){
		    //console.log("malus 3 ");
		    affiche("Vous reculez de trois cases");
		    deplacement=deplacement-3;
		   
		    
		}if(ran == 8){
			//console.log("malus 4 : bloqué");
			affiche("Vous passez votre tour");
			deplacement = 20;
		
		
		}
		return (deplacement);
	}
	
	function affiche(message){
			//document.getElementById('info').innerHTML = message;
			$('#info').append('<div>'+message+'</div>');
			// On l'efface 8 secondes plus tard
		/*	setTimeout(function() {
			document.getElementById('info').innerHTML = "";
			},3000);*/
	}

	</script>

	<?php
		Misc::bottomNavBar(" ");
	?>
	<div id="stats" class="card text-white bg-dark" style="margin: auto; min-width: 400px; width: 400px; display: flex; position:fixed; z-index: 1000; top: 50%; left: 50%">
		<div class="card-header text-center bg-warning text-dark"><b>Progression des joueurs </b>
			<button id="hide" type="button" class="close" aria-hidden="true">×</button>
		</div>
		<div class="card-body scroll-575pxy">
			<div class="container">
				<div class="row no-gutters" id = "result" style="text-align: center;">
				</div>
			</div>
		</div>
	</div>
	
	<script>
	$("#stats").hide();
		$("#stats").draggable({
		    handle: ".card-header"
		});
		$("#hide").click(function(){
	        $("#stats").hide();
	    });
	    $("#show").click(function(){
	        $("#stats").show();
	    });
	</script>
</body>
</html>
