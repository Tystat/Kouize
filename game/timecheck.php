<?php
    //date_default_timezone_set("Europe/London");
	include_once ('../lib/db.php');
	include_once ('../lib/question.php');
	
	$db = new Db;  
	$db->connect(true);
	
	$quest = new Question($db);
	
	$cle=$_GET['numgame'];
	$db->select('games','codegame',$cle,$result);
	
	$startDate = strtotime($result[0]['timestamp']);
	$currentDate = time();
	$diff = $currentDate-$startDate;
	
	$numQuest = $diff/21;
	$numQuest = floor($numQuest);
	$db->updateMult('games',array('numquestion'), array($numQuest),array('codegame'),array("=$cle"),false);
	$db->selectMult('players',array('id_game','pseudo'),array("=".$_GET['id'],"=".$_GET['pseudo']),$resultusr,"",false);
	$arrayInit = array("phase"=>"init");
	$arrayQuest = array("phase"=>"quest","numquest"=>$numQuest,"score"=>$score,"statut"=>$resultusr[0]['statut']);
	$arrayAns = array("phase"=>"ans","numquest"=>$numQuest,"score"=>$score);
	$arrayAnim = array("phase"=>"anim","numquest"=>$numQuest,"score"=>$score);
	
	
	
	$jsonQuest = json_encode($arrayQuest);
	$jsonAns = json_encode($arrayAns);
	$jsonAnim = json_encode($arrayAnim);
	$jsonInit = json_encode($arrayInit);
	
	if($diff<7)//tant que 7 sec ne sont passé
		echo $jsonInit; //on reste sur le plateau initial
	else if ((($diff-7)%21)<12)//après 12 sec on passe à l'état 2, sinon on reste dans l'état 1
		echo $jsonQuest;
	else if ((($diff-7)%21)<15)//après 3 sec on passe à l'état 3, sinon on reste dans l'état 2
		echo $jsonAns;
	else if ((($diff-7)%21)<21)//après 6 sec on passe à l'état 1, sinon on reste dans l'état 3
		echo $jsonAnim;

	/*
	$game = $db->select('games','codegame',$cle,$result,false); //selectionne la partie en cours
	$listQuestion = $result;

	foreach($listQuestion as $game){
		$game['listquestion'];				//récupère la liste des questions de la partie
	}
	$arrayQuestion = json_decode ($game['listquestion']);
	$quest->getById($arrayQuestion[0]['id'],$result);
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
	*/
?>