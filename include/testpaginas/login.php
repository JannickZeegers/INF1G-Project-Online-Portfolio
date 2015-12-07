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
            echo "<pre>";
            var_dump(portfolio_get_user_details(portfolio_login($_POST["userName"], $_POST["userPass"])));
            echo "</pre>";
        }
        ?>
        <h1>Login</h1>
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
            <p>Username:<br><input type='text' name='userName'></p>
            <p>Password:<br><input type='password' name='userPass'></p>
            <p><input type='submit' name='submit' value='login'></p>
        </form>
    </body>
</html>
