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
				if (!empty($_POST['voornaam']) && !empty($_POST['achternaam']) && !empty($_POST['mail']) && !empty($_POST['pass']) && !empty($_POST['gebrnaam']) && !empty($_POST['rol'])) {
					$voornaam = htmlentities($_POST['voornaam']);
					$achternaam = htmlentities($_POST['achternaam']);
					$mail = htmlentities($_POST['mail']);
					$pass = htmlentities($_POST['pass']); 
					$gebrnaam = htmlentities($_POST['gebrnaam']);
					$rol = htmlentities($_POST['rol']);
					registreer($voornaam, $achternaam, $mail, $pass, $gebrnaam, $rol);  
					echo "<p class='error'>Registratie-process gelukt, er is een mail naar u toegestuurd</p>"; 
					header("refresh:2; url=index.php"  );
				} else {
					echo "<p class='error'>U dient wel beide velden in te vullen.</p>";
				} 		
			?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>