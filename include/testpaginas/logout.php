<?php
include '../portfolio.php';
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
        <title></title>
    </head>
    <body>
        <h1>Uitloggen</h1>
        <?php
        if(session_destroy())
        {
            echo '<p>U bent uitgelogd</p>';
        }
        else
        {
            echo '<p>Er ging iets mis! Probeer het nog eens</p>';
        }
        ?>
    </body>
</html>
