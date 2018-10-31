<?php
	include_once ('../lib/db.php');
	$db = new Db;  
	$db->connect(true);
	$cle = $_GET['numgame'];
	$db->select('games','codegame',$cle,$result); //récupère la ligne de la table games de la partie qu'on vient de créer
	$list=$result[0]['listquestion'];
	echo json_encode($list);
?>