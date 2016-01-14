<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
<!--
    Inlogpagina
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
					$voornaam = $_POST['voornaam'];
					$achternaam = $_POST['achternaam'];
					$mail = $_POST['mail'];
					$pass = $_POST['pass']; 
					$gebrnaam = $_POST['gebrnaam'];
					$rol = $_POST['rol'];
					registreer($voornaam, $achternaam, $mail, $pass, $gebrnaam, $rol);  
					echo "<p class='error'>Registration-process succesfull. You are being redirected.</p>"; 
					header("refresh:10; url=../../index.php"  );
				//} else {
				//	echo "<p class='error'>You need to fill in the form</p>";
				//	} 
						
			?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>