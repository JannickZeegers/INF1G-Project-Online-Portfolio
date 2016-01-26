<?php
session_start();
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
			<form id="registreer" method="POST" action="resetpass_exe.php"> 
				<label>Oud wachtwoord</label>
				<p><input type="password" name="oudepass" /></p>
				<label>Achternaam</label>
				<p><input type="password" name="nieuwepass" /></p>
				<p><input type="submit" value="Registreer" name="submit"/></p> 
			</form>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>