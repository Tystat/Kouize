 <?php //
    session_start();
    include_once('../lib/alert.php');
    include_once('../lib/visitor.php');
	include_once('../lib/db.php');

    $db = new Db;
    $db->connect(true);
    
    Visitor::log($db);
    
    $friendel = $_GET['friendel'];
    $pseudoJoueur = $_SESSION['usr-data']['pseudo'];
    
    echo $friendel."<br>";
    echo $pseudoJoueur."<br>";
 
    $db->delMult('friends',array('friend1','friend2'),array("=$pseudoJoueur","=$friendel"),false);
    $db->delMult('friends',array('friend1','friend2'),array("=$friendel","=$pseudoJoueur"),false);
    
    header("location:".  $_SERVER['HTTP_REFERER']);
 ?>