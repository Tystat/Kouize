<?php	
date_default_timezone_set("Europe/London");
header("Content-Type: text/event-stream\n\n");
//header('Content-type: text/html; charset=utf-8');
include_once('../lib/db.php');
include_once("../lib/question.php");
ignore_user_abort(true);
$db=new Db;
$db->connect(true);
$quest = new Question($db);

$cle=$_GET['cle_game'];
$db->select('games','codegame',$cle,$resultDate,'',false);
$startDate = strtotime($resultDate[0]['timestamp']);    //récupère l'heure de lancement de la partie
$currentDate = 0;
$diff = 0;
$numQuest = 0;

$state=0;//initialisation de $state à 0
$old_state=0; //initialisation de $old_state à 0

$game = $db->select('games','codegame',$cle,$result,false); //selectionne la partie en cours
$listQuestion = $result;

foreach($listQuestion as $game){
	$game['listquestion'];				//récupère la liste des questions de la partie
}
$arrayQuestion = json_decode ($game['listquestion']);

while(1)
{
	$currentDate = time();  //récupère l'heure actuelle
	$diff = $currentDate-$startDate; //différence entre l'heure actuelle et l'heure de lancement
	$numQuest = (($diff-5)/23)+1;
	$numQuest = floor($numQuest);
	$db->selectMult('players',array('id_game','pseudo'),array("=".$_GET['id'],"=".$_GET['pseudo']),$resultusr,"",false);
	$db->updateMult('games',array('numquestion'), array($numQuest),array('codegame'),array("=$cle"),false);

	$quest->getById($arrayQuestion[$numQuest],$result);
	$textQuestion = $result;
	
	//-----------------------RATIO--------------

	$db->select('questions','question',$textQuestion[0]['question'],$resultGood,"",false);
	$db->select('questions','question',$textQuestion[0]['question'],$resultBad,"",false);
	
	$CountGood = $resultGood['0']['countgood'];
	$CountBad = $resultBad['0']['countbad'];
	
	//$ratio = $CountGood / ($CountBad + $CountGood); /!\ GENERATION DE LOG EXCESSIVE, +2mb/s, DIVISION PAR ZERO
	
	if($ratio < 0.167){
		$score = 6;
	}
	else if($ratio < 0.334){
		$score = 5;
	}
	else if($ratio < 0.501){
		$score = 4;
	}
	else if($ratio < 0.667){
		$score = 3;
	}
	else if($ratio < 0.834){
		$score = 2;
	}
	else{
		$score = 1;
	}
		
//--------------------MACHINE A ETAT----------------------
	
	if($diff<7)//tant que 7 sec ne sont passé
		$state = 0; //on reste sur le plateau initial
	else if ((($diff-7)%27)<18)//après 12 sec on passe à l'état 2, sinon on reste dans l'état 1
		$state = 1;
	else if ((($diff-7)%27)<21)//après 3 sec on passe à l'état 3, sinon on reste dans l'état 2
		$state=2;
	else if ((($diff-7)%27)<27)//après 6 sec on passe à l'état 1, sinon on reste dans l'état 3
		$state = 3;
	
		
	if($old_state!=$state)  //si $state et $old_state sont différents
	{
		switch ($state) 
		{
			case 1:
				echo "event: quest\n";
				$dataArray = array ("question" => $textQuestion[0]['question'],"prop1" => $textQuestion[0]['answer'],"prop2" => $textQuestion[0]['proposal1'],"prop3" => $textQuestion[0]['proposal2'],"prop4" => $textQuestion[0]['proposal3'],"statut" => $resultusr[0]['statut'],"pts" => $score);
				echo 'data:'.json_encode($dataArray)."\n\n";
				break;
			  case 2:
				echo "event: ans\n";
				echo "data: $emptydata\n\n";
				break;
			case 3:
				echo "event: animpawn\n";
				echo "data: $emptydata\n\n";
				break;
		}
		$old_state = $state;
	}
	flush();
	ob_flush();
	sleep(1);
}
?>
