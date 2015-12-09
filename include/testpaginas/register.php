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
        <?php
        include "../portfolio.php";
        // put your code here
        if(isset($_POST["submit"]))
        {
            portfolio_register($_POST["userName"], $_POST["userPass"], $_POST["userEmail"], "Voornaam", "Achternaam", "student");
        }
        ?>
        <h1>Registreer</h1>
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
            <p>Username:<br><input type='text' name='userName'></p>
            <p>Password:<br><input type='password' name='userPass'></p>
            <p>Email:<br><input type='text' name='userEmail'></p>
            <p><input type='submit' name='submit' value='Sign Up'></p>
        </form>
    </body>
</html>
