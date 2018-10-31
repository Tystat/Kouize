<?php
	include_once('../lib/db.php');
	include_once("../lib/secure.php");
//Connection to the database, retrieve and send initial JSON table
	Secure::get('id');
	$database=new Db;
	$database->connect();
	$database->selectMult("players",array("id_game"),array('='.$_GET['id']),$result,'',false);
	$jsonResult=json_encode($result);
//	echo "<pre>";

//	echo "</pre>";
	echo $jsonResult;
?>