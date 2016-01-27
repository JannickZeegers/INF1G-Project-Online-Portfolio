<?php
include_once "portfolio.php";
$logout = portfolio_logout();
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
            <div id="header">
                <div id="header">
                    <?php include 'inc/header.php'; ?>
                </div>
            </div>
            <div id="content">
            <h2>Logout</h2>
            <?php
            if($logout)
            {
                echo '<p>U bent uitgelogd</p>';
                echo '<p><a href="admin.php">Ga terug naar de homepage</a></p>';
            }
            else
            {
                echo '<p>Er ging iets mis! Probeer het nog eens</p>';
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
