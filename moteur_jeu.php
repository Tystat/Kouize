 <?php
    include_once('../');
    include_once('../lib/question.php');
    include_once('../lib/db.php');
    include_once('../lib/visitor.php');
    
    $db=new Db;
    $db->connect(true);
    ////visitor::log($db);	// enregistre l'ip dans la base de données
    
?>