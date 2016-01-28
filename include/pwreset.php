<?php
include_once 'portfolio.php';

$urlmail = filter_input(INPUT_GET, 'mail', FILTER_VALIDATE_EMAIL);

$wasReset = false;
$message = '';
if(isset($_POST['submit']))
{
    $email = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
    if($email)
    {
        $userId = portfolio_get_user_id_by_mail($email);
        if(portfolio_reset_pass($userId))
        {
            $message = 'Wachtwoord gereset. Je ontvangt een mail met je nieuwe wachtwoord.';
            $wasReset = true;
        }
        else
        {
            $message = 'Gebruiker niet gevonden';
        }
    }
    else
    {
        $message = 'Vul een geldig email adres in';
    }
}
?>
<!DOCTYPE html>
<!--

    Dit is een admin paneel waar een ingelogde gebruiker menus heeft om dingen te doen.
    Bijvoorbeeld een materiaal uploaden, materialen, vakken en cijfers bekijken of dingen beoordelen.
    Ook het gastenboek/berichtensysteem via dit bereikbaar?
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Reset wachtwoord</title>
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
            <h2>Wachtwoord reset</h2>
            <?php
                echo '<p>' . $message . '</p>';
                if(!$wasReset)
                {
                    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                    echo '<p>Email adres <input type="text" name="mail" value="' . $urlmail . '"></p>';
                    echo '<p><input type="submit" value="submit" name="submit"></p>';
                    echo '</form>';
                }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
