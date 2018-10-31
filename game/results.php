<?php
session_start();
include_once("../lib/misc.php");
include_once("../lib/db.php");
include_once("../lib/visitor.php");
include_once('../lib/question.php');
include_once('../lib/analytics.php');
$db=new Db;
$db->connect(true);
$quest=new Question($db);
//visitor::log($db);
?>
<!doctype html>
<html lang="fr">
  <head>
	 <title>Fin du jeu - Kouize</title>
	<?php
	Misc::genericCss();
	Misc::bootstrap(); 
   
	Misc::topNavBar("Jouer");
	?>
	<style>
		.cell-full { max-width:1px; width:100%; }
		.cell-ellipsis { overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }
	</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="../js/amis.js"></script>
	</head>
		<?php
				Analytics::track();
		?>
	<body>
		<?php Misc::genericIcon();?>
<div class="wmax-1024 mx-auto">
	 <div class="container-fluid mt-5 pt-5 pb-5 h-72">
		<div class="col" >
			<div class="row justify-content-md-center ">
				<div class="col-sm-4">
					<div class="card text-white bg-dark mb-5 ">
						<div class="card-header text-center "><b>Classement </b><div id='nbjoueur'></div>
						</div>
							<div class="card-body scroll-575pxy">
								<table class='text-white' id="result"> 
									<tr align="center"><th>Place</th> <th>Pseudo</th> <th>Score</th> </tr>
								</table>
							</div>
					</div>
				</div>
				<div class="row justify-content-md-center">
					<div class="col-sm-auto">
						<div class="card text-white bg-dark mb-0 d-none d-xl-block">
							<div class="card-header text-center"><b>Liste de questions</b>
							</div>
								<div class="card-body scroll-350pxy text-center">
									<table class='text-white' id="questions" align="center">
									<tr><th>Question</th><th>&nbsp; &nbsp;</th><th>Réponse</th><th>&nbsp; &nbsp;</th><th>% de bonne réponses</th></tr>
									</table>
								</div>
						</div>
					</div>
		   		</div>
	  		</div>
		</div>
	</div>
</div>
<?php
	Misc::bottomNavBar(" ");
?>
	</body>
	<script>
	
	function getScores(){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var obj = JSON.parse(this.responseText);
				scorejson = obj.sort(function (a, b) {
					return b.score - a.score;
				});
				document.getElementById("result").innerHTML = '<tr align="center"><th>Place</th> <th>Pseudo</th> <th>Score</th> </tr>';
				var i=0;
				scorejson.forEach(function(element) {
					i++;
					if (i == 1)
						document.getElementById("result").innerHTML += '<tr align="center"><td><img src="../media/winner.svg" alt="winner icon" height="20" width="20" align="center"></td><td class="cell-full cell-ellipsis">' + element.pseudo + '</td><td>' + element.score + '</td>';
					else
						document.getElementById("result").innerHTML += '<tr align="center"><td>' + i + '</td><td class="cell-full cell-ellipsis">' + element.pseudo + '</td><td>' + element.score + '</td>';
				});
				document.getElementById("nbjoueur").innerHTML = '(' + i + ' joueurs)';
			}
		}
		xmlhttp.open("GET", "../lib/gamestate.php?id=<?=$_SESSION['idgame']?>", true);
		xmlhttp.send();
	}
	getScores();
	
	function getQuest(){
		//console.log("Getting Questions");
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				var obj = JSON.parse(this.responseText);
				questjson = JSON.parse(obj);
				var i=0;
				var percent="";
				console.log(questjson);
				var questjsonrep = questjson.slice(0,<?php $db->select('games', 'id', $_SESSION['idgame'], $result, ""); echo $result[0]['numquestion'];?>)
				questjsonrep.forEach(function(element) {
					var good=parseInt(questjson[i].countgood);
					var bad=parseInt(questjson[i].countbad);
					if ((questjson[i].countgood!=0)&&(questjson[i].countgood!=0))
					{
						percent = (good / (good + bad))*100;
						var newpercent = percent.toFixed();
					}
					else
						percent = "Pas assez de résultats";	
					document.getElementById("questions").innerHTML += '<tr><td>'+questjson[i].question+'</td><td>&nbsp; &nbsp;</td><td> '+questjson[i].answer+'</td><td>&nbsp; &nbsp;</td><td>'+newpercent+'%</td></tr>';
					i++;
				});
			}
		}
		xmlhttp.open("GET", "process_questions.php?numgame=<?=$_SESSION['codegame']?>", true);
		xmlhttp.send();
	}
	getQuest();
</script>
</html>
