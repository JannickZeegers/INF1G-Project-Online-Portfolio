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
        <title>Ons Portfolio - Bekijk cijfers</title>
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
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_user_details($targetId);
                    if($targetData)
                    {
                        if(($targetData['rol'] === 'student' && portfolio_user_is_of_type(array('slb', 'docent')))
                            || portfolio_user_is_of_type(array('admin'))
                            || $targetId === $_SESSION['user']['gebruikersId'])
                        {
                            echo '<h2>' . $targetData['voornaam'] . ' ' . $targetData['achternaam'] . '</h2>';
                            echo '<h3>Cijfers</h3>';
                            $notes = portfolio_get_student_notes($targetId);
                            if(count($notes) > 0)
                            {
                                echo '<table class="tableLeft">';

                                echo '<tr><th rel="row">' . 'Gebruikers ID' . '</th><td>' . $targetData['gebruikersId'] . '</td></tr>';
                                echo '<tr><th rel="row">' . 'Voornaam' . '</th><td>' . $targetData['voornaam'] . '</td></tr>';
                                echo '<tr><th rel="row">' . 'Achternaam' . '</th><td>' . $targetData['achternaam'] . '</td></tr>';
                                echo '<tr><th rel="row">' . 'E-Mail adres' . '</th><td>' . $targetData['eMail'] . '</td></tr>';
                                echo '<tr><th rel="row">' . 'Rol' . '</th><td>' . $targetData['rol'] . '</td></tr>';

                                echo '</table>';
                            }
                            else
                            {
                                echo '<p>Geen cijfers gevonden</p>';
                            }
                            
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze pagina te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Gebruiker niet gevonden!</p>';
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
