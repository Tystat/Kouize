<?php

include_once ('dbconfig.php');
//include_once ('alert.php');


class Db
{
	
	// Database handler
	private $_db;

	// Connect to the mySQL database : FONCTIONNEL
	function connect($redirectOnError = true)
	{
		
		// Connect to the sql databas
		try 
		{
			$this->_db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} 
		catch(Exception $e) 
		{
			// If requested, redirect on error
			if ($redirectOnError) db::error('Location: /','[db::connect]',$e);
			// Store the error
			$this->_db->connect_error=$e;
		}
	} 

	// Return the ID of the last inserted row 
	function lastId()
	{
		return  $this->_db->lastInsertId();
	}

	// Create and populate a new row in a given table -- FONCTIONNEL
	//ex : $db->insert('questions',array('question','answer'),array('test','oui'));
	function insert($table, $fields, $data, $redirectOnError = true)
	{
		
		$varArray=[];  
		for ($i=0;$i<count($data);$i++)    array_push($varArray, ':var'.$i );
		// Create sql query query query (vache query)
		
		
		$sql = 'INSERT INTO `'.$table.'` (`'.implode("` , `", $fields).'`) VALUES ('.implode(" , ", $varArray).')';
		//The ultimate Clean/Secure fonction
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			for ($i=0;$i<count($data);$i++)
				$stmt->bindParam( $varArray[$i], $data[$i]);
			$stmt->execute(); 
		
		}
		catch(Exception $e) 
		{   
			// If requested, redirect on error
			if ($redirectOnError) db::error('Location: /','[db::insert]',$e);
	
			// An error occured, return false
			return false;
		}
		// Success, return true
		return true;
	}


	// Select data from table where the field $field==$data
	// ex : $db->select('questions','id','11',$result); avec $result la variable retournée
	function select($table, $field, $data, &$result, $option="", $redirectOnError = true)  //-- FONCTIONNEL
	{
		// Prepare the sql query
		$sql = 'SELECT * FROM `'.$table.'` WHERE '.$field.' LIKE :var '.$option;
	
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':var', $data);
			$stmt->execute(); 
		} 
		catch(Exception $e) 
		{
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::select]',$e);
			
			// An error occured, return false;
			$result=array();
			return false;
		}
		
		// Success, return true
		$result=$stmt->fetchAll();
		return true;
	}
	
	function countTable($table, $field,&$result, $redirectOnError = true)  //-- Non fonctionnel
	{
		// Prepare the sql query
		$result = 'SELECT COUNT (`'.$field.'`) FROM `'.$table;
	
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			$stmt->execute(); 
		} 
		catch(Exception $e) 
		{
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::select]',$e);
			
			// An error occured, return false;
			return false;
		}
		
		// Success, return true
		return true;
	}

	// Update the fields of table
	// ex $db->update('questions',array('answer','question'),array('nouvelleRéponse','nouvelleQuestion'),'id','0');
	function update($table, $fields, $data, $field , $value, $redirectOnError = true) //-- FONCTIONNEL
	{
		// Prepare the sql qurey
		$varArray=[];
		$fieldArray=[];
		for ($i=0;$i<count($fields);$i++)    
		{
			array_push($varArray, ':var'.$i );
			array_push($fieldArray, $fields[$i].' = :var'.$i );
		}
	
		// Create sql query
		$sql = 'UPDATE `'.$table.'` SET '.implode(" , ", $fieldArray).' WHERE '.$field.' = :value ;';
	
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			for ($i=0;$i<count($data);$i++) 
			{
				
				$stmt->bindParam( $varArray[$i], $data[$i]);
			}
			$stmt->bindParam( ':value', $value);
			$stmt->execute(); 
	
		} 
		catch(Exception $e) 
		{   
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::update]',$e);
	
			// An error occured, return false
			return false;
		}
		
		// Success, return true
		return true;
	}
	
		//Delete with multiple criteria, the first character of the data_crit string must be =,!,< or > for equal,different,less than and more than
	function delMult($table, $field_crit , $data_crit, $redirectOnError = true)
	{
		// Prepare the sql qurey
		
		$varArray_crit=[];
		$fieldArray_crit=[];
		for ($i=0;$i<count($field_crit);$i++)    
		{
			array_push($varArray_crit, ':varcrit'.$i );
			if ($data_crit[$i][0]=="=")
			{
				array_push($fieldArray_crit, $field_crit[$i].'=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]=="!")
			{
				array_push($fieldArray_crit, $field_crit[$i].'!=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 2);
			}
			if ($data_crit[$i][0]=="<")
			{
				array_push($fieldArray_crit, $field_crit[$i].'<:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]==">")
			{
				array_push($fieldArray_crit, $field_crit[$i].'>:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
		}
	
		// Create sql query
		$sql = 'DELETE FROM '.$table.' WHERE '.implode(" AND ", $fieldArray_crit).';';
		echo $sql;
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			for ($i=0;$i<count($data_crit);$i++) 
			{
				
				$stmt->bindParam( $varArray_crit[$i], $data_crit[$i]);
				
			}
			$stmt->execute(); 
	
		} 
		catch(Exception $e) 
		{   
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::update]',$e);
			// An error occured, return false
			return false;
		}
		
		// Success, return true
		return true;
	}
	
	//Update with multiple criteria, the first character of the data_crit string must be =,!,< or > for equal,different,less than and more than
	function updateMult($table, $field_updt, $data_updt, $field_crit , $data_crit, $redirectOnError = true)
	{
		// Prepare the sql qurey
		$varArray_updt=[];
		$fieldArray_updt=[];
		for ($i=0;$i<count($field_updt);$i++)    
		{
			array_push($varArray_updt, ':varupdt'.$i );
			array_push($fieldArray_updt, $field_updt[$i].' = :varupdt'.$i );
		}
		
		$varArray_crit=[];
		$fieldArray_crit=[];
		for ($i=0;$i<count($field_crit);$i++)    
		{
			array_push($varArray_crit, ':varcrit'.$i );
			if ($data_crit[$i][0]=="=")
			{
				array_push($fieldArray_crit, $field_crit[$i].'=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]=="!")
			{
				array_push($fieldArray_crit, $field_crit[$i].'!=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 2);
			}
			if ($data_crit[$i][0]=="<")
			{
				array_push($fieldArray_crit, $field_crit[$i].'<:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]==">")
			{
				array_push($fieldArray_crit, $field_crit[$i].'>:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
		}
	
		// Create sql query
		$sql = 'UPDATE `'.$table.'` SET '.implode(" , ", $fieldArray_updt).' WHERE '.implode(" AND ", $fieldArray_crit).';';
		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			for ($i=0;$i<count($data_updt);$i++) 
			{
				
				$stmt->bindParam( $varArray_updt[$i], $data_updt[$i]);
				
			}
			for ($i=0;$i<count($data_crit);$i++) 
			{
				
				$stmt->bindParam( $varArray_crit[$i], $data_crit[$i]);
				
			}
			$stmt->execute(); 
	
		} 
		catch(Exception $e) 
		{   
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::update]',$e);
			// An error occured, return false
			return false;
		}
		
		// Success, return true
		return true;
	}
	
	//Select with multiple criteria, the first character of the data_crit string must be =,!,< or > for equal,different,less than and more than
	function selectMult($table, $field_crit , $data_crit, &$result, $option="", $redirectOnError = true)  //-- FONCTIONNEL
	{
		$varArray_crit=[];
		$fieldArray_crit=[];
		for ($i=0;$i<count($field_crit);$i++)    
		{
			array_push($varArray_crit, ':varcrit'.$i );
			if ($data_crit[$i][0]=="=")
			{
				array_push($fieldArray_crit, $field_crit[$i].'=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]=="!")
			{
				array_push($fieldArray_crit, $field_crit[$i].'!=:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 2);
			}
			if ($data_crit[$i][0]=="<")
			{
				array_push($fieldArray_crit, $field_crit[$i].'<:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
			if ($data_crit[$i][0]==">")
			{
				array_push($fieldArray_crit, $field_crit[$i].'>:varcrit'.$i );
				$data_crit[$i]=substr($data_crit[$i], 1);
			}
		}
		
		// Prepare the sql query
		$sql = 'SELECT * FROM `'.$table.'` WHERE '.implode(" AND ", $fieldArray_crit).$option;

		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			for ($i=0;$i<count($data_crit);$i++) 
			{
				$stmt->bindParam( $varArray_crit[$i], $data_crit[$i]);
				
			}
			$stmt->execute(); 
		} 
		catch(Exception $e) 
		{
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::select]',$e);
			
			// An error occured, return false;
			$result=array();
			return false;
		}
		
		// Success, return true
		$result=$stmt->fetchAll();
		return true;
	}

	// delete a row in the table
	//ex : $db->del('questions','id','1');
	function del($table, $field, $data, $redirectOnError = true)
	{
		// Prepare the sql query
		$sql = 'DELETE FROM '.$table.' WHERE '.$field.' = :var';

		// Prepare, fill and execute the query
		try 
		{     
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':var', $data);
			$stmt->execute(); 
		} 
		catch(Exception $e) 
		{   
			// If requested, redirect on error
			if ($redirectOnError)  db::error('Location: /','[db::delete]',$e);
	
			// An error occured, return false
			return false;
		}
		
		// Success, return true
		return true;
	}


	// An error occured, create a message and redirect
	function error($redirect, $caller='', $error='')
	{
		//echo 'Il y a eu une erreur dans la fonction '.$caller.'<br>';
		//echo $error;

		// An error occured, queue error message
		
		// Service mode
		//Message::danger('An error occured.','Something\'s wrong with the database '.$caller.'.');
		
		// For debug only
		//Message::danger('An error occured.','Something\'s wrong with the database '.$caller.'.'.$error);
		
		// Redirect to the following link
		header($redirect);
		die();
	}
	
}
?>