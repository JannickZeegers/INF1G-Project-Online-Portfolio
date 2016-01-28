<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
<!--
    registreer
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Login</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="header">
                    <?php include 'inc/header.php'; ?>
                </div>
            </div>
            <div id="content">
			<?php
				$userId = $_GET['user']; 
				if(portfolio_reset_pass($userId))
                                {
                                    echo '<p>Gebruiker geaccepteerd!</p>';
                                }
                                else
                                {
                                    echo '<p>Er ging iets mis. Probeer het later nog een keer</p>';
                                }
			?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>