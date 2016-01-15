<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
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
			<h1>Wachtwoord reset</h1>
				<?php 
					$oudpass = $_POST['oudpass']; 
					$nieuwpass = $_POST['nieuwepass'];
					resetpass($oudpass, $nieuwpass); 
				?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>