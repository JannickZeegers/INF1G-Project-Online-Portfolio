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
        <title>Ons Portfolio - Login</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
        <h1>Login</h1>
        <?php
        if(isset($_POST["submit"]))
        {
            $un = filter_input(INPUT_POST, 'userName');
            $pw = filter_input(INPUT_POST, 'userPass');
            if(!empty($un) && !empty($pw))
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
            else
            {
                echo "<p>Vul aub een gebruikersnaam en wachtwoord in</p>";
            }
        }
        if(!isset($_SESSION['user']))
        {
            // put your code here
            ?>
            <p>Testaccounts</p>
            <p>Student:<br>test<br>test</p>
            <p>SLB:<br>henk<br>test</p>
            <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
                <p>Gebruikersnaam:<br><input type='text' name='userName'></p>
                <p>Wachtwoord:<br><input type='password' name='userPass'></p>
                <p><input type='submit' name='submit' value='login'></p>
            </form>
            <?php
        }
        else
        {
            echo '<p>U bent al ingelogd als ' . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . '</p>';
            echo '<p><a href="logout.php">Klik hier om uit te loggen</a></p>';
        }
        ?>
        </div>
    </body>
</html>
