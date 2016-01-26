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
			<h1>Registreer</h1>
			<form id="registreer" method="POST" action="register_exe.php"> 
				<label>Voornaam</label>
				<p><input type="text" name="voornaam" /></p>
				<label>Achternaam</label>
				<p><input type="text" name="achternaam" /></p>
				<label>Mail</label>
				<p><input type="text" name="achternaam" /></p>
				<label>Gebruikersnaam</label>
				<p><input type="text" name="gebrnaam" /></p>
				<label>Pass</label>
				<p><input type="password" name="pass" /></p>
				<label>Rol</label>
				<p><input type="text" name="rol" /></p>
				<p><input type="submit" value="Registreer" name="submit"/></p> 
			</form>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
