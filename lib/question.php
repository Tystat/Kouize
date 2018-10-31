<?php
	include_once ('db.php');
	
	class Question
	{
		private $_db;
	
		function __construct($db) {
			$this->_db = $db;
		}
		//Insérer une question
		function add($question, $answer, $proposal1, $proposal2, $proposal3, $theme,$validate=0,$redirectOnError = true)
		{
			$this->_db->insert('questions',array('question','answer','proposal1','proposal2','proposal3','theme','validate'),
			array("$question","$answer","$proposal1","$proposal2","$proposal3","$theme","$validate"),$redirectOnError);
		}
	
		//Récupérer une question par ID
		function getById($id,&$result,$redirectOnError = true)
		{
			$this->_db->select('questions','id',$id,$result,"",$redirectOnError);
			return $result;
		}
	
		//Récupérer toutes les questions
		function getAll($redirectOnError = true){
			
			$this->_db->select('questions','validate','1',$result,"",$redirectOnError);
			return $result;
		}
		
		function searchQuest($search,$redirectOnError = true){
			
			$this->_db->select('questions','question',$search,$result,"",$redirectOnError);
			return $result;
		}
		
		//Récupérer toutes les questions par Thèmes
		function getByTheme($theme,&$result,$redirectOnError = true)
		{
			$this->_db->select('questions','theme',$theme,$result,"",$redirectOnError);
			return $result;
		}
		
		// Selectionne x questions aléatoirement dans la database     
		function getRandQuestion($redirectOnError = true)
		{
			$this->_db->select('questions','validate','1',$result,"ORDER BY RAND() LIMIT 100",$redirectOnError);
			return $result;
		}
		
		function getUnvalidQuestion($redirectOnError = true){
			$this->_db->select('questions','validate','0',$result,"",$redirectOnError);
			return $result;
		}
		
	}

?>