<?php

class Secure
{
	// Secure a single variable
	public static function variable($singleVar)
	{
		$singleVar = trim($singleVar);
		$singleVar = stripslashes($singleVar);
		$singleVar = htmlspecialchars($singleVar);
		return $singleVar;
	}

	// Secure the $_POST variable
	public static function post()
	{
		foreach ($_POST as $key => $data)
			$_POST[$key]=Secure::variable($data);
	}

	// Secure the $_GET variable
	public static function get()
	{
		foreach ($_GET as $key => $data)
			$_GET[$key]=Secure::variable($data);
	}


	// Return true if the $_SESSION variable $varName exists and is not empty
	public static function isSession($singleVar)
	{
		return (isset($_SESSION[$singleVar]) && !empty($_SESSION[$singleVar]))?true:false;
	}


	// Return true if all the $_SESSION in the array $varArray exists and are not empty
	public static function areSession($multiVar)
	{
		foreach ($multiVar as $varName)
			if (!Secure::isSession($varName)) return false;
		return true;
	}


	// Return true if the $_POST variable $varName exists and is not empty
	public static function isPost($singleVar)
	{
		return (isset($_POST[$singleVar]) && !empty($_POST[$singleVar]))?true:false;
	}


	// Return true if all the $_POST in the array $varArray exists and is not empty
	public static function arePost($multiVar)
	{   
		foreach ($multiVar as $varName)
			if (!Secure::isPost($varName)) return false;
		return true;
	}

	// Return true if the $_GET variable $varName exists and is not empty
	public static function isGet($singleVar)
	{
		return (isset($_GET[$singleVar]) && !empty($_GET[$singleVar]))?true:false;
	}

	// Return true if all the $_GET in the array $varArray exists and is not empty
	public static function areGet($varArray)
	{
		foreach ($varArray as $varName)
			if (!Secure::isGet($varName)) return false;
		return true;
	}

}

?>