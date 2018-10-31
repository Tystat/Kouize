<?php
session_start();
/* Cette page a pour objectif de répertorier et d'inviter de nouveaux amis */
    include_once('../lib/alert.php');
	include_once('../lib/misc.php');
	include_once('../lib/visitor.php');
	include_once('../lib/db.php');
	include_once('../lib/analytics.php');

    $db = new Db;
    $db->connect(true);

    Visitor::log($db);

?>
<!DOCTYPE html>
<html>
    <head>
        
        <?php
            Misc::genericCss();
        	Misc::bootstrap();
        	Misc::genericIcon();
	        Misc::genericLogo();
        	//Analytics::track();
        ?>
        <!-- Importe jQuery and jQuery UI (Interface utilisateur) -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        
        <title>Amis - Kouize</title>
		
    </head>
    <body>
    	<?php
			Misc::topNavBar('Accueil');
			Alert::display();
		?>
		<br>;
		<br>
		<br>
		<form>
            <input type="text" id="recherche2" />
        </form>
        
    	
    </body>
</html>