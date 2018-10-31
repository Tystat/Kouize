<?php
    session_start();
	include_once('../lib/db.php');
	include_once('../lib/chat.php');
	include_once("../lib/secure.php");

	
	$db = new Db;
	$db ->connect(true);
	
	$cle = $_SESSION['idgame'];
	$chat= new Chat($db);
	//$messages = $chat -> getMess($cle);
	//$db->selectMult('minichat',array('message_chat','id_game'),array("=%","=$cle"),$resultChat,'',false);
	$db->select('minichat','id_game',$cle,$resultChatTEST,'',false);

//	echo $cle.'<br>';
	echo json_encode($resultChatTEST);
	//var_dump($resultChat);
	//var_dump(json_encode ($resultChatTEST));
	

?>