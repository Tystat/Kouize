<?php
	session_start();
// Cette page sert à envoyer les suggestions de pseudos pour la page d'ajout d'amis
    include_once('../lib/alert.php');
	include_once('../lib/visitor.php');
	include_once('../lib/db.php');
	include_once('../lib/analytics.php');
	
	$db = new Db;
	$db->connect(true);	// connexion à la bdd
	
	$value = $_GET['term'];

	$db->select('users','pseudo','%'.$value.'%',$result);	// selection de tous les utilisateurs enregistrés de la bdd
	$jsonArray = array();	// création du tableau json pour tous les stocker
	
	
	foreach($result as $champ){
		$subArray = array('value' => $champ['pseudo'], 'label' => $champ['pseudo'], 'link' => "#");		// encodage de chaque ligne du tableau (contenant uniquement le pseudo) en un sous tableau lisible pour la fonction ajax autocomplete
		array_push($jsonArray, $subArray);		// La fonction push sert à rajouter une ligne en fin de tableau
	}

	echo json_encode($jsonArray);	// On envoie le tableau complet en format json
?>

