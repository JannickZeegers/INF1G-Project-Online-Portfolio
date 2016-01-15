<?php
include_once "portfolio.php";

/*
 * Code voor de rest van de pagina zodat het menu klopt na inloggen
 */
$loggedIn = false;
$message = '';
if(isset($_POST["submit"]))
{
    $un = filter_input(INPUT_POST, 'userName');
    $pw = filter_input(INPUT_POST, 'userPass');
    if(!empty($un) && !empty($pw))
    {
        if(portfolio_login($un, $pw))
        {
            $message = "<p>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</p>\n";
            $loggedIn = true;
        }
        else
        {
            $message = "<p>Gebruikersnaam en/of wachtwoord niet correct!</p>\n";
        }
    }
    else
    {
        $message = "<p>Vul aub een gebruikersnaam en wachtwoord in</p>";
    }
}
?>
<!DOCTYPE html>
<!--
    Inlogpagina
-->
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
            <h1>Login</h1>
            <?php
            echo $message;
            if(!isset($_SESSION['user']))
            {
                // put your code here
                ?>
                <p>Testaccounts</p>
                <p>Zowel naam als wachtwoord:</p>
                <p>docent, student, slb, admin</p>
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
                echo '<p><a href="admin.php">Ga terug</a></p>';
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
