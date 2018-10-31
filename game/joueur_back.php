<?php
	header("Content-Type: text/event-stream");
	header("Cache-Control: no-cache");
	header("Access-Control-Allow-Origin: *");
	
	include_once ('../lib/db.php');
	include_once('../lib/visitor.php');
	ignore_user_abort(true);
	$db = new Db;   
	$db->connect(true);
	//visitor::log($db);	// enregistre l'ip dans la base de données
	$cle = $_GET['numgame'];
	
	$lastResult = 0;
	while (1) {
		if(connection_aborted()){
			exit();
		}
		$db->select('players','id_game',"$cle",$result,"",false);
		if($lastResult !=$result){
			$lastResult=$result;
			echo "event: ping\n";
			echo 'data: '.json_encode($result);
			echo "\n\n";
		}
		ob_flush();
		flush();
		sleep(1);
	}
?>