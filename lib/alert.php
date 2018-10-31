<?php

/*

--DOCUMENTATION--

Cette classe vous permet de transmettre des messages/alertes entre 2 pages, utile quand vous avez une page de saisie et une page de traitement séparée par exemple,
dans la page de traitement vous pouvez envoyer une alerte et l'afficher dans votre page de saisie.

Tout d'abord il faut inclure la classe message :
include_once"../lib/alert.php";


Pour envoyer un message (plusieurs types de messages sont disponibles -> success,info,warning et dangers: 
Alert::danger("TITRE","Contenu");

Pour afficher les messages envoyés précédemment : 
Alert::display();

*/

class Alert
{
	
	// Ajout d'une nouvelle alerte "success" à la liste d'attente
	public static function success($title,$message='')
	{
		$message = (empty($message))?'':'<hr>'.$message;
		$_SESSION['MSG_success'] .= '<h4 class="alert-heading text-success"><i class="fa fa-check-circle fa-lg" aria-hidden="true"></i> '.$title.'</h4>'.$message;
	}

	// Ajout d'une nouvelle alerte "info" à la liste d'attente
	public static function  info($title,$message='')
	{
		$message = (empty($message))?'':'<hr>'.$message;
		$_SESSION['MSG_info'] .= '<h4 class="alert-heading text-info"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></i> '.$title.'</h4>'.$message;
	}
	
	// Ajout d'une nouvelle alerte "warning" à la liste d'attente
	public static function warning($title,$message='')
	{
		$message = (empty($message))?'':'<hr>'.$message;
		$_SESSION['MSG_warning'] .= '<h4 class="alert-heading text-warning"><i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i></i> '.$title.'</h4>'.$message;
	}

	// Ajout d'une nouvelle alerte "danger" à la liste d'attente
	public static function  danger($title,$message='')
	{
		$message = (empty($message))?'':'<hr>'.$message;
		$_SESSION['MSG_danger'] .= '<h4 class="alert-heading text-danger"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></i> '.$title.'</h4>'.$message;
	}
	


	// Affiche les alertes de la liste d'attente
	public static function  display()
	{
		$isMessage=false;
	
		// Affiche une alerte "success"
		if ( isset($_SESSION['MSG_success']) && !empty($_SESSION['MSG_success']))
		{
			echo '<div class=" mt-5"></div>';
			echo '<div class="alert alert-success alert-dismissible fade show w-100" style="position:fixed; z-index: 999;" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo $_SESSION['MSG_success'].'</div>';
			unset($_SESSION['MSG_success']);
		}
		
		// Affiche une alerte "info"
		if ( isset($_SESSION['MSG_info']) && !empty($_SESSION['MSG_info']))
		{
			echo '<div class=" mt-5"></div>';
			echo '<div class="alert alert-info alert-dismissible fade show w-100" style="position:fixed; z-index: 999;" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo $_SESSION['MSG_info'].'</div>';
			unset($_SESSION['MSG_info']);
		}
	
		// Affiche une alerte "warning"
		if ( isset($_SESSION['MSG_warning']) && !empty($_SESSION['MSG_warning']))
		{
			echo '<div class=" mt-5"></div>';
			echo '<div class="alert alert-warning alert-dismissible fade show w-100" style="position:fixed; z-index: 999;" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo $_SESSION['MSG_warning'].'</div>';
			unset($_SESSION['MSG_warning']);
		}
		
		// Affiche une alerte "danger"
		if ( isset($_SESSION['MSG_danger']) && !empty($_SESSION['MSG_danger']))
		{
			echo '<div class=" mt-5"></div>';
			echo '<div class="alert alert-danger alert-dismissible fade show w-100" style="position:fixed; z-index: 999;" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
			echo '<span aria-hidden="true">&times;</span>';
			echo '</button>';
			echo $_SESSION['MSG_danger'].'</div>';
			unset($_SESSION['MSG_danger']);
		}
		
	}
	
	
}
?>