<?php

class Visitor
{
	
	// Log the current visitor
	public static function log($db)
	{
		$db->insert('log_visitors',array('uri','language','host','referer','user_agent','https','ip_addr','ip_forw','ip_client'),
		array(  $_SERVER['REQUEST_URI'] ,
				$_SERVER['HTTP_ACCEPT_LANGUAGE'] ,
				$_SERVER['HTTP_HOST'] ,
				$_SERVER['HTTP_REFERER'] ,
				$_SERVER['HTTP_USER_AGENT'] ,
				$_SERVER['HTTPS'] ,
				$_SERVER['REMOTE_ADDR'] ,
				$_SERVER['HTTP_X_FORWARDED_FOR'] ,
				$_SERVER['HTTP_CLIENT_IP'] ) , 
				false );
		//return $db->lastId();
	}
}

?>