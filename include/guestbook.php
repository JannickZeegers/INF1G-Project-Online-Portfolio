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
        <title>Ons Portfolio - Gastenboek</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!-- TODO: EVERYTHING -->
        <div id="container">
            <div id="header">
                <?php include 'inc/header.php'; ?>
            </div>
            <div id="content">
            <?php
            if(isset($_SESSION['user']))
            {
                $targetId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    if((portfolio_user_is_of_type(array('student')) && $_SESSION['user']['gebruikersId'] == $targetId)
                    || portfolio_user_is_of_type(array('admin')))
                    {
                        $usrData = portfolio_get_user_details($targetId);
                        
                        if($usrData)
                        {
                            $msgData = portfolio_get_guestbook_messages($targetId);
                            
                            echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                            echo '<h2>Gastenboek van ' . $usrData['voornaam'] . ' ' . $usrData['achternaam'] . '</h2>';
                            echo '<h3>Lijst berichten</h3>';
                            if(count($msgData) > 0)
                            {
                                echo '<table class="tableLeft">';
                                echo '<tr><th rel="col">naam</th><th rel="col">mail</th><th rel="col">bericht</th><th rel="col">verwijder</th></tr>';
                                foreach($msgData as $msg)
                                {
                                    echo '<tr>'
                                            . '<td>' . $msg['zendernaam'] . '</td>'
                                            . '<td>' . $msg['email'] . '</td>'
                                            . '<td>' . $msg['bericht'] . '</td>'
                                            . '<td><a href="removeguestbook.php?message=' . $msg['berichtId'] . '" target="_blank">verwijder</a></td>'
                                            . '</tr>';
                                }
                                echo '</table>';
                            }
                            else
                            {
                                echo '<p>Er zijn geen berichten gevonden</p>';
                            }
                        }
                        else
                        {
                            echo '<p>Er is hier niks</p>';
                        }                        
                    }
                    else
                    {
                        echo '<p>U heeft geen toegang tot deze pagina</p>';
                    }
                }
                else
                {
                    echo '<p><a href="admin.php">Ga terug</a></p>';
                }
            }
            else
            {
                echo "<h2>Log eerst in!</h2>";
                echo '<p><a href="login.php">Klik hier om in te loggen</a></p>';
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
