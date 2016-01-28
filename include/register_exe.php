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
				if (retrieve_request($bericht)) { 
					print_r ($fetcharray);  
				} 
			
				
			
				//if (     ) {}
					//$voornaam = 
					//$achternaam = 
					//$mail = 
					//$gebrnaam = 
					//$pass = 
					//$optie = 
					
					
					//register($voornaam, $achternaam, $mail, $pass, $gebrnaam, $rol);  
					//header("refresh:2; url=index.php"  );
				//} 		
			?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>