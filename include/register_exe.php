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
				if (!empty($_POST['voornaam']) && !empty($_POST['achternaam']) && !empty($_POST['mail']) && !empty($_POST['gebrnaam']) && !empty($_POST['rol'])) {
					$voornaam = htmlentities($_POST['voornaam']);
					$achternaam = htmlentities($_POST['achternaam']);
					$mail = htmlentities($_POST['mail']);
					$gebrnaam = htmlentities($_POST['gebrnaam']);
					//$pass = htmlentities($_POST['wachtwoord']); 
					$optie = htmlentities($_POST['rol']);
					switch ($optie) { 
					case 'student':
						$rol = "student";
					break;
					case 'docent':
						$rol = "docent";
					break; 
					case 'slb':
						$rol = "slb"; 
					break;
					case 'admin':
						$rol = "admin";
					break;
					}
					
					$bericht = "<p>{$voornaam}</p>  
								<p>{$achternaam}</p> 
								<p>{$mail}</p> 
								<p>{$gebrnaam}</p> 
								<p>{$optie}</p>";
					mail ('info@ons-portfolio.nl', 'Aanmeldings-verzoek', $bericht); 
					//register($voornaam, $achternaam, $mail, $wachtwoord, $gebrnaam, $rol);  
					echo "<p class='error'>Registratie-process gelukt, bevestiging aanmedling volgt spoedig</p>"; 
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