<?php
    //date_default_timezone_set("Europe/London");
	include_once ('../lib/db.php');
	$db = new Db;  
	$db->connect(true);
	$idgame=$_GET['idgame'];
	$player=$_GET['pseudo'];
	$db->selectMult('players',array('id_game','pseudo'),array("=$idgame","=$player"),$resultScore,"",false);
	$score = $resultScore[0]['score'] + $_GET['pts1'];
	$db->updateMult('players',array('score'),array($score),array('id_game','pseudo'),array("=$idgame","=$player"),false);
?>