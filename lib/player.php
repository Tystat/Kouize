<?php
include_once ('db.php');

class Player
{
	private $_db;

	function __construct($db) {
		$this->_db = $db;
	}
	
	//Insérer un joueur
	function add($pseudo, $score, $idgame, $statut,$redirectOnError = true)//OK
	{
		$this->_db->insert('players',array('pseudo','score','id_game','statut'),
		array("$pseudo","$score","$idgame","$statut"),$redirectOnError);
	}

	//Récupérer un joueur par ID
	function getById($id,$redirectOnError = true)//OK
	{
		$this->_db->select('players','id',$id,$result,"",$redirectOnError);
		return $result;
	}

	//Récupérer tous les joueurs OK
	function getAll(&$result,$redirectOnError = true){
		$this->_db->select('players','id','%',$result,"",$redirectOnError);
		return $result;
	}
	
	//Récupérer toutes les joueurs par score
	function getByScore($score,$redirectOnError = true)//OK
	{
		$this->_db->select('players','score',$score,$result,"",$redirectOnError);
		return $result;
	}
	
	//Récupérer tous les joueurs d'une partie
	function getByGame($idgame,$redirectOnError = true) //OK
	{
		$this->_db->select('players','id_game',$idgame,$result,"",$redirectOnError);
		return $result;
	}
	
	//Trier tous les joueurs par score
	function sortByScore($redirectOnError = true)//OK
	{
		$this->_db->select('players','score','%',$result,"ORDER BY score DESC",$redirectOnError);
		return $result;
	}
	
	//Trier les joueurs par score dans une partie
	function sortByScoreinGame($idgame,$redirectOnError = true) //OK
	{
		$this->_db->select('players','id_game',$idgame,$result,"ORDER BY score DESC",$redirectOnError);
		return $result;
	}
	
	function playerLeaved($player,$gameId,$redirectOnError = true) //OK
	{
		$this->_db->delMult('players',array('id_game','pseudo'),array("=$gameId","=$player"));
		$this->_db->select('games','nbplayer',$nbplayer,$redirectOnError);
		$newnbplayer=$nbplayer-1;
		$this->_db->update('games','nbplayer',$nbplayer,$newnbplayer,$redirectOnError);
	}
	
	
}

?>