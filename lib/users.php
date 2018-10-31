<?php


class Users {
	
	private $_db;

	function __construct($db) {
		$this->_db = $db;
	}
	//Fonctions pour se logger -----------------------------------------------------------------------------------------------------------------------------------------------------------------
	// The user signed in
	public static function login($userData,$superUser)
	{
		$_SESSION['usr-data']=$userData;
		$_SESSION['usr-isLogged']=true;
		$_SESSION['usr-isSuperUser']=$superUser;
	}
	
	// Return true if the user is superuser
	public static function isSuperUser()
	{
		return $_SESSION['usr-isSuperUser'];
	}
	
	// Return true if the user is logged
	public static function isLogged()
	{
		return $_SESSION['usr-isLogged'];
	}
	
	// Return the user id
	public static function id()
	{
		return $_SESSION['usr-data']['id'];
	}
	
	// The user signed out
	public static function logout()
	{
		$_SESSION['usr-isLogged']=false;
		unset($_SESSION['usr-isLogged']);
		unset($_SESSION['usr-data']);
		unset($_SESSION['usr-isSuperUser']);
		session_unset();
	}
	
	//Fonctions AJOUTER - MODIFIER - SUPPRIMER -------------------------------------------------------------------------------------------------------------------------------------------------
	function isMailInDB($mailInDb)
	{
		$this->_db->select('users','mail',$mailInDb,$resultMail);
		if (!empty($resultMail)) 
		{
			return true;
		}
		else {
			return false;
		}
	}
	
	function add($lastname, $firstname, $mail, $pseudo, $password)
	{
		$this->_db->insert('users',array('lastname','firstname','mail','pseudo','password'),array($lastname,$firstname,$mail,$pseudo,$password),true);
	}
	
	function supp($mail)
	{
		$this->_db->del('users','mail',$mail);
	}
  
	
	function modif($lastname,$firstname,$mail,$pseudo,$password,$oldMail)
	{
		$password_crypt=password_hash( $password , PASSWORD_BCRYPT );
		$this->_db->update('users',array('lastname','firstname','mail','pseudo','password'),array($lastname,$firstname,$mail,$pseudo,$password_crypt),'mail',$oldMail,true);
	}
	
	
}
?>