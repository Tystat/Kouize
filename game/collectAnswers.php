<!--https://adminkouize-adminkouize.c9users.io/game/collectAnswer.php-->
<?php
	session_start();
	include_once ('../lib/db.php');
	include_once('../lib/visitor.php');
	
	$db = new Db;   
	$db->connect(true);
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	$updAns=$_GET['updQuestAns'];
	$numgame=$_SESSION['idgame'];
	$player=$_SESSION['player'];
	$goodAnswer=$_GET['goodAnswer'];
	$quest=$_GET['quest'];
	
	//COMPTE DU RATIO + SCORE---------------------------------------
	$db->select('questions','question',$quest,$resultBad,"",false);
	$CountGood = $resultBad['0']['countgood'];
	$CountBad = $resultBad['0']['countbad'];

	$db->selectMult('players',array('id_game','pseudo'),array("=$numgame","=$player"),$resultScore,"",false);
	
	//SI BONNE REPONSE ---------------------------------------------
	if($goodAnswer == 1){
		$oldscore = $resultScore[0]['score'];
		$score = $resultScore[0]['score'] + $_GET['pts'];
		$avance = $score - $oldscore;
		//UPDATE COUNTGOOD -------------------------------------------------------------------------------------
		$NewCountGood= $CountGood + 1;
		$db->updateMult('questions',array('countgood'),array($NewCountGood),array('question'),array("=$quest"),false);
		//------------------------------------------------------------------------------------------------------
	}
	else if($goodAnswer == 0){
		$score = $resultScore[0]['score'];
		//UPDATE COUNTBAD --------------------------------------------------------------------------------------
		$NewCountBad= $CountBad + 1;
		$db->updateMult('questions',array('countbad'),array($NewCountBad),array('question'),array("=$quest"),false);
		//------------------------------------------------------------------------------------------------------
	}
	
	if($score>=30)
	{
		$db->updateMult('players',array('statut'),array('3'),array('id_game'),array("=$numgame"),false);
	}
	
	if (isset($updAns)){
		$db->updateMult('players',array('score','caseavance'),array($score,$avance),array('id_game','pseudo'),array("=$numgame","=$player"),false);
	}
	
	
	
	
	die();
	//header('Location: /tmp/prototype/examplePageQuizz.php');
?>