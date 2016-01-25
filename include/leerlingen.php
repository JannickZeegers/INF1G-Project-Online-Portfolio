<?php
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
				portfolio_connect();
				retrieve_students();
				
				
				foreach ($students as $student) { 
					echo '<p><a href="img/avatar_{$student}"</p>'; 
				}
				
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>