<?php
/*
	header("Content-Type: text/event-stream");
	header("Cache-Control: no-cache");
	header("Access-Control-Allow-Origin: *");
	
	include_once ('../lib/db.php');
	include_once('../lib/visitor.php');
	ignore_user_abort(true);
	$db = new Db;   
	$db->connect(true);
	
	//visitor::log($db);	// enregistre l'ip dans la base de données
	
	$cle=$_GET['numgame'];
	$pseudo = $_GET['pseudo'];
	$lastResult = 0;
	
	
	while (1)
	{
		if(connection_aborted()){
			exit();
		}
		$db->select('minichat','id_game',$cle,$result,"",false);
		//$db->selectMult('players',array('id_game','statut'),array("=$cle",'!=0'),$result,"",false);
	  
		if($lastResult !=$result)
		{
			$lastResult=$result;
			
			echo "event: ping\n";
			echo 'data: '.json_encode($result);
			echo "\n\n";
		}
		ob_flush();
		flush();
		sleep(1);
	}
*/
?>


<?php

	session_start();
	include_once("../lib/chat.php");
	include_once('../lib/visitor.php');

	$db=new Db;
	$db->connect(true);
	visitor::log($db);	// enregistre l'ip dans la base de données
	$chatAff = new Chat($db);
	
	$cle=$_GET['numgame'];
	$pseudo = $_GET['pseudo'];
	
	echo $_GET['numgame']."<br>";
	
	$messageList = $chatAff->getMess($cle);
	var_dump($messageList); 
	//echo $messageList['message_chat'];
	
	foreach($messageList as $message){
		?>
			<ul class="list-unstyled mt-1 mb-2">
				<li><i class="fas fa-user-circle"></i><?php echo " ".$message['pseudo_chat']; ?></li>
				<div style="border: 1px solid grey; border-radius : 9px; background : #888888;">
					<li><?php echo $message['message_chat']; ?></li>
				</div>
			</ul> 
		<?php
		}
		
	
?>    
