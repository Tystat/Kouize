<?php

class Question
{
	
	private $db;
	private $Qdata;
	
	
	// Constructor of the class (link to the db)
	function __construct($db)
	{
		$this->db=$db;
	}
	
	
	// Load a given question from the database
	function load($id)
	{
		$this->db->select('question_data','idquestion',$id,$this->Qdata);
		return (count($this->Qdata)==1)?true:false;
	}
	
	// Return the text of the question
	function getId()
	{
		return $this->Qdata[0]['id'];
	}
	
	// Return the text of the question
	function getQuestion()
	{
		return $this->Qdata[0]['question'];
	}
	
	// Return the text of the question
	function getQuestionText()
	{
		return self::toText($this->Qdata[0]['question']);
	}
	
	// Return the text of the question
	function getAnswer()
	{
		return $this->Qdata[0]['answer'];
	}
	
	// Return the text of the question
	function getLanguage()
	{
		return $this->Qdata[0]['language'];
	}
	
	// Return the text of the question
	function getSource()
	{
		return $this->Qdata[0]['source'];
	}

	// Get alternate languages
	function alternateLang()
	{
		$this->db->select('question_data','id_question', $this->Qdata[0]['id_question'],$others);
		return $others;
	}

	// Get total number of questions in a given language
	function howMany($lang)
	{
		$this->db->select('question_data','language',$lang,$Questions);
		return (count($Questions));
	}
	
	// Convert a question to text (for header's description)
	public static function toText($question)
	{
		// Strip html tags
		$text=strip_tags($question);
		// Remove MathJax LaTeX delimiters
		$text=str_replace('\(','',$text);
		$text=str_replace('\)','',$text);
		$text=str_replace('$$','',$text);
		// Decode HTML entities : &amp; -> &
		$text=html_entity_decode($text);
		return $text;
	}

}


?>