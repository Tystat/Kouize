<?php 
include_once ('db.php');

class Chat {
	
	private $_db;
	
	function __construct($db) 
	{
		$this->_db = $db;
	}
	
	function ajouterMess($pseud,$mess,$numgame)
	{
		$this->_db->insert('minichat',array('pseudo_chat','message_chat','id_game'),array($pseud,$mess,$numgame),false);
	}

	function getMess($idgame)
	{
		$this->_db->selectMult('minichat',array('message_chat','id_game'),array('%',"=$idgame"),$resultAff,"",false);
		return $resultAff;
	}
}
?>