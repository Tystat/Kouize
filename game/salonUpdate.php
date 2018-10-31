<?php
	include_once ('../lib/db.php');
	include_once('../lib/visitor.php');
	$db = new Db;  
	$db->connect(true);
	$cle = $_GET['numgame'];
	$db->select('players','id_game',"$cle",$result,"",false);
	echo json_encode($result);
?>