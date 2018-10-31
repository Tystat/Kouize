<?php
	session_start();

	include_once('../lib/misc.php');
	include_once("../lib/db.php");
	include_once("../lib/visitor.php");
	include_once('../lib/question.php');
	
	$db=new Db;
	$db->connect(true);
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
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
	
		#jeu

		{
			width: 1245px;
			height: 700px;
			margin-left: auto;
			margin-right: auto;
			border: 2px black solid;
			background: url('../media/tmpjeu/plateauER+.1.png');
			

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
	?>
	
	
		
	<?php $np=$_GET['np']; $np=1;?>
	
		
			<div id="jeu" style="width: 1245px;height: 700px;">
				
				<div class ="mt-5" style="display: flex; flex-direction: column; width : 256px;z-index: 300;">
					<img style="height:144px; width:256px;" class = "left"  src="../../media/logo.gif"></img>
					<button type="button" style="opacity:0.9;" class="btn btn-dark btn text-white mx-5"  data-toggle="modal" data-target="#modalStats"><div><b>Stats Partie</b></div>
					</button>
				</div>
				
				
						
					<?php if ($np==1){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: -150px;left: 853px;position: relative;z-index: 200;">
					<?php }else if ($np==2){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php }else if ($np==3){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php }else if ($np==4){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php }else if ($np==5){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange2" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php }else if ($np==6){ ?>
						<img id="Red" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Red2" src="../media/tmpjeu/NinjaRougeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Orange2" src="../media/tmpjeu/NinjaOrangeVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
						<img id="Green2" src="../media/tmpjeu/NinjaVertVues/FrontRight.png" style="top: 68px;left: 853px;position: absolute;z-index: 200;">
					<?php }?>

			</div>

	<style>
	.left {
    	float: left;
    	margin: 0;
    	padding: 0;
	}
	</style>
 
		<div id="kouizeModal" class="modal fade" role="dialog" data-controls-modal="kouizeModal" data-backdrop="static" data-keyboard="false"> 
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="rounded bg-light wmax-960">
						
						<div class="modal-header text-light container mx-auto bg-dark py-4 text-center">
							<h1 class="display-5" id="quest"></h1>
						</div>

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
							
							<script type="text/javascript">
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
							</script>
							
						</container>
					</div>
				</div>  <!-- end of modal content -->
			</div>  <!-- end of modal dialog -->
		</div>  <!-- end of modal -->
	</div>
	
		<script>
		// tableau de coordonnée
		var place = 
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
		
		
		var nbdep1;
		var s1=-1;
		var caseavance;
		var obj;
		
		var evtSource = new EventSource("core.php?cle_game=<?=$_SESSION['number']?>&id=<?=$_SESSION['idgame']?>&pseudo=<?=$_SESSION['player']?>");
		evtSource.onmessage = function(e){

		}
		
		evtSource.addEventListener("quest", function(e) 
		{
			randomize();
			obj = JSON.parse(e.data);
			if(obj.statut==3){
				document.location.href = "results.php"; // redirection lors de la fin de partie (30 pts)
			}
			else{
				caseavance=obj.pts;
				//Changement de la question du modal
				$('#quest').html('');
				$('#quest').append(obj.question,"(",obj.pts,"pts)");
				//Changement des réponses du modal
				$('#endTime1').html('');
				$('#endTime1').append(obj.prop1);
				$('#endTime2').html('');
				$('#endTime2').append(obj.prop2);
				$('#endTime3').html('');
				$('#endTime3').append(obj.prop3);
				$('#endTime4').html('');
				$('#endTime4').append(obj.prop4);
				//Affichage du modal
				$('#kouizeModal').modal('show');
				setTimeout(timerButton, 10000);
			}
		}, false);

		evtSource.addEventListener("ans", function(e) 
		{
			//console.log ("Phase Reponse");
		}, false);

		evtSource.addEventListener("animpawn", function(e) 
		{
			//console.log ("Phase Animation");
			
			$('#kouizeModal').modal('hide');
			
			//MOUVEMENT ----------------------------------------------------------------------------------------------------
				nbdep1=caseavance;// echo $resultavance[0]['caseavance'];?>;
			
				var i;
				
				for (i = 1; i <= nbdep1*2; i=i+2){
					
					if ($("#endTime1").hasClass("selectQuest")){
						s1=s1+2;
						$("#Red").animate({left:(((place[s1-1]-40)*0.824479)/900*700)+'px',top:((((place[s1]-120)*0.824479)/900*700)-218)+'px'}, "slow");
					}
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
			
			
			//$db->select('players',array('id_game','pseudo'),array($_SESSION['idgame'],$_SESSION['player']),$resultavance,"",false);

		}, false);
	</script>
	
	<script>
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
	</script>

	<style>
	.zoom:hover {
		-ms-transform: scale(1.1); /* IE 9 */
		-webkit-transform: scale(1.1); /* Safari 3-8 */
		transform: scale(1.1); 
	}
	</style>
	
	<script>
	
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
						url : '../game/collectAnswers.php?updQuestAns='+obj.prop1+'&quest='+obj.question+'&goodAnswer=1'
					});
					//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop1+"&quest="+obj.question+"&goodAnswer="+true;
				}
					
				else if($("#endTime2").hasClass("selectQuest")){
					$.ajax({
						type: 'GET',
						url : '../game/collectAnswers.php?updQuestAns='+obj.prop2+'&quest='+obj.question+'&goodAnswer=0'
					});
					//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop2+"&quest="+obj.question;
				}
					
				else if($("#endTime3").hasClass("selectQuest")){
					$.ajax({
						type: 'GET',
						url : '../game/collectAnswers.php?updQuestAns='+obj.prop3+'&quest='+obj.question+'&goodAnswer=0'
					});
					//window.location = "/game/collectAnswers.php?updQuestAns="+obj.prop3+"&quest="+obj.question;
				}
					
				else if($("#endTime4").hasClass("selectQuest")){
					$.ajax({
						type: 'GET',
						url : '../game/collectAnswer.php?updQuestAns='+obj.prop4+'&quest='+obj.question+'&goodAnswer=0'
					});
					//window.location = "/game/collectAnswer.php?updQuestAns="+obj.prop4+"&quest="+obj.question;
				}
				else{
					$.ajax({
						type: 'GET',
						url : '../game/collectAnswer.php?updQuestAns='+NULL+'&quest='+obj.question+'&goodAnswer=0'
					});
				}
				
				
			}

	</script>
	
	<script>
		$(document).ready(function()
		{
			$("#myBtn").click(function()
			{
				$("#kouizeModal").modal({backdrop: false});
			});
		});
	</script>
	
	<?php
		Misc::bottomNavBar(" ");
	?>

	<script>
	
	 function Comparator(a, b) {
	   if (a[3] > b[3]) return -1;
	   if (a[3] < b[3]) return 1;
	   return 0;
	 }
	
	
	if(typeof(EventSource) !== "undefined") {
		var source = new EventSource("../lib/gamestate.php?id=<?=$_SESSION['idgame']?>");
		source.onmessage = function(event) {
			//document.getElementById("result").innerHTML += event.data + "<br>";
			var scorejson= JSON.parse(event.data);
			scorejson = scorejson.sort(Comparator);
			//document.getElementById("result").innerHTML ='<tr align="center"><th>Position</th> <th>Pseudo</th> <th>Score</th> <th>Nombres de bonnes réponses</th> </tr>';
			document.getElementById("result").innerHTML ='';
			var i=0;
			scorejson.forEach(function(element) {
				i++;
			  //document.getElementById("result").innerHTML += '<tr align="center"><td>'+i+'</td><td>'+element.pseudo+'</td><td>'+element.score+'</td><td> <div class="progress"> <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: '+element.score+'%"></div></div></td>';
			document.getElementById("result").innerHTML += '<div class="col"><b>'+i+'.</b></div><div class="col-4 cell-full cell-ellipsis"><b>'+element.pseudo+'</b></div><div class="col">'+element.score+'pts</div><div class="col-4"><div class="progress"><div id="progressBarScore" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: '+(element.score*(10/3))+'%"></div></div></div><div class="w-100"></div>';
												  
			});
		};
	

	
		};
	</script>

	<!-- MODAL PROGRESSION JOUEURS-->
	<div id="modalStats" class="modal fade" role="dialog"> 
			<div class="modal-dialog">
				<div class="modal-content bg-dark">
					<div class="card text-white bg-dark">
									
						<div class="card-header text-center bg-warning text-dark"><b>Progression des joueurs </b>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
				</div>  <!-- end of modal content -->
			</div>  <!-- end of modal dialog -->
		</div>  <!-- end of modal -->


</body>
</html>
