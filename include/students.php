<?php
//session_start(); Niet nodig, portfolio.php doet dit al voor je. :)
include 'portfolio.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Overzicht leerlingen</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <?php include 'inc/header.php'; ?>
            </div>
            <div id="content">
            <h2>Leerling</h2>
            <?php
				echo '<table>';
						
						retrieve_students();
						
				echo  '</table>'; 
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>