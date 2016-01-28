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
			<form id="registreer" method="POST" action="register_exe_mail.php"> 
				<label>Voornaam</label>
				<p><input type="text" name="voornaam" /></p>
				<label>Achternaam</label>
				<p><input type="text" name="achternaam" /></p>
				<label>Mail</label>
				<p><input type="text" name="mail" /></p>
				<label>Gebruikersnaam</label>
				<p><input type="text" name="gebrnaam" /></p>
				<label>Rol</label>
				<p><select name="rol">
					<option value="student">Student</option>
					<option value="docent">Docent</option>
					<option value="slb">SlB</option>
					<option value="admin">Admin</option>
				</select></p>
				<p><input type="submit" value="Registreer" name="submit"/></p> 
			</form>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
