<?php
include_once 'portfolio.php';
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
        <title>Ons Portfolio - Vakken van gebruiker</title>
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
            <?php
            if(isset($_SESSION['user']))
            {
                //Alles
                echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                
                $user = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                $subject = filter_input(INPUT_GET, 'subject', FILTER_VALIDATE_INT);
                
                if($user && $subject)
                {
                    if(portfolio_add_user_subject($user, $subject))
                    {
                        echo '<p>Vak toegevoegd aan gebruiker!</p>';
                    }
                    else
                    {
                        echo '<p>Kon vak niet toevoegen! Mogelijk is dit vak al aan de gebruiker toegewezen!</p>';
                    }
                }
            }
            else
            {
                echo "<h2>Log eerst in!</h2>";
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
