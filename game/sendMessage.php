<?php
	session_start();
	
	include_once('../lib/db.php');
	include_once('../lib/chat.php');
	include_once('../lib/secure.php');
	$db= new Db;
	$db->connect(true);

	Secure::post();
	$chat=new Chat($db);
	
	//$pseudo=$_SESSION['usr-data']['pseudo'];
	
	$pseudo=$_SESSION['player'];
	$numgame=$_SESSION['idgame'];
	$message=$_POST['chatSent'];
	
	echo 'pseudo : '.$pseudo.'<br>';
	echo 'numgame : '.$numgame.'<br>';
	echo 'message : '.$message.'<br>';
	
	if ($message != NULL)
	{
		$chat->ajouterMess($pseudo,$message,$numgame);
	}
?>