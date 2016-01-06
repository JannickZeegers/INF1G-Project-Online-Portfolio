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
            if(portfolio_login($_POST["userName"], $_POST["userPass"]))
            {
                echo "<p>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</p>\n";
            }
            else
            {
                echo "<p>Gebruikersnaam en/of wachtwoord niet correct!</p>\n";
            }
        }
        ?>
        <h1>Login</h1>
        <p>Student:<br>test<br>test</p>
        <p>SLB:<br>henk<br>test</p>
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
            <p>Username:<br><input type='text' name='userName'></p>
            <p>Password:<br><input type='password' name='userPass'></p>
            <p><input type='submit' name='submit' value='login'></p>
        </form>
    </body>
</html>
