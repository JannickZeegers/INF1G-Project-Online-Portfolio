<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Logout</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
        <h1>Logout</h1>
        <?php
        if(session_destroy())
        {
            echo '<p>U bent uitgelogd</p>';
            echo '<p><a href="index.php">Ga terug naar de homepage</a></p>';
        }
        else
        {
            echo '<p>Er ging iets mis! Probeer het nog eens</p>';
        }
        ?>
        </div>
    </body>
</html>
