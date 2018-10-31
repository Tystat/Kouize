<?php
	session_start();
	
	include_once("../lib/db.php");
	include_once("../lib/secure.php");
	include_once("../lib/alert.php");
	include_once("../lib/users.php");
	include_once('../lib/visitor.php');
	
	//------------------------sécurité-----------------------------------//
	
	Secure::post();
	
	if (!Secure::arePost(array ('pseudoJoin','clef')))
	{
		Alert::Danger('Formulaire incomplet','Entrez un pseudo et la clef pour rejoindre une partie !');
		header('Location: /users/menu_jouer.php');
		die();
	}
	
	$clef = $_POST['clef'];
	$tpseudo = $_POST['pseudoJoin'];
	$_SESSION['player'] = $_POST['pseudoJoin'];
	
	
	//------------------------vérifie l'existence de la clé-----------------------------------//
	
	$dB = new Db;
	$dB->connect(true);	
	//visitor::log($dB);	// enregistre l'ip dans la base de données
	$dB->select('games','codegame',$clef,$result); //récupère la ligne de la partie rejointe
	$dB->select('players','id_game',$result[0]['id'],$result2); //récupère toutes les lignes avec l'id_game de cette partie pour récupérer les identifiants des joueurs
	
	if (!$clef==$result[0]["codegame"])
	{
		Alert::Danger('Code introuvable','La clef saisie est erronée ou inexistante !');
		header('Location: /users/menu_jouer.php');
		die();
	}
	
	//------------------------vérifie que le pseudo n'est pas déjà utilisé dans la partie-----------------------------------//
	
	foreach($result2 as $pseudo)
	{
		if ($tpseudo==$pseudo['pseudo'])
		{
			Alert::Danger('Impossible','Pseudo déjà utilisé dans cette partie !');
			header('Location: /users/menu_jouer.php');
			die();
		}
	}
	
	//------------------------redirection sur la page du salon-----------------------------------//
	
	if(count($result2)!=0)
	{
		for ($x = 0; $x <= count($result2); $x++)
		{
			foreach($result2[$x] as $host)
			{
				if ($result2[$x]['statut']==2|$result2[$x]['statut']==0){
					Alert::success('Vous êtes dans la partie de '.$result2[$x]['pseudo'],'Attendez '.$result2[$x]['pseudo'].' pour commencer à jouer !');
					header('Location: /game/salon.php');
					
					//------------------------ajout de joueur-----------------------------------//
		
					$dB->update('games',array('nbplayers'),array($result[0]['nbplayers']+1),'codegame',$clef,true); //incrémente le nb de joueur dans la table games à la ligne correspondante
					
					$dB->insert('players',array('pseudo','id_game','statut'),array($tpseudo,$result[0]['id'],1),true); //ajoute le joueur dans bdd de la partie correspondante
					
					$_SESSION['codegame']=$clef;
					$_SESSION['idgame']=$result[0]['id'];
					$_SESSION['player']=$tpseudo;
					$_SESSION['playerStatus']=1;
					die();
				}else{
					Alert::danger('Echec','Vous avez trouvé une partie sans hôte !');
					header('Location: /');
					die();
				}
				
			}
		}
	}
	else 
	{
		Alert::danger('Echec','Cette partie n\'existe pas.');
		header('Location: /');
		die();
	}
	
?>

