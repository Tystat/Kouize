<?php
	ignore_user_abort(true);
	include_once('../lib/db.php');
	include_once('../lib/player.php');
	include_once("../lib/secure.php");
	include_once('../lib/visitor.php');
	Secure::get('player');
	Secure::get('gameId');
	$database=new Db;
	$database->connect();
	//visitor::log($database);	// enregistre l'ip dans la base de données
	$player=new Player($database);
	$player->playerLeaved($_GET['player'],$_GET['gameId']);
	//header('Location: /');
	exit;
?>