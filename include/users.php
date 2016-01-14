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
        <title>Ons Portfolio - Gebruikers</title>
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
                if(portfolio_user_is_of_type(array('admin')))
                {
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    echo '<p><a href="adduser.php">Maak nieuwe gebruiker aan</a></p>';
                    echo '<h3>Lijst gebruikers</h3>';
                    //TODO: Verander dit naar ALLE gebruikers
                    $gebruikers = portfolio_get_users();
                    if(count($gebruikers) > 0)
                    {
                        echo '<table class="tableLeft">';
                        echo '<tr><th rel="col">naam</th><th rel="col">rol</th><th rel="col">details</th></tr>';
                        foreach($gebruikers as $vak)
                        {
                            echo '<tr>'
                                    . '<td>' . $vak['voornaam'] . ' ' . $vak['achternaam'] . '</td>'
                                    . '<td>' . $vak['rol'] . '</td>'
                                    . '<td><a href="viewuser.php?user=' . $vak['gebruikersId'] . '">bekijk</a></td>'
                                    . '</tr>';
                        }
                        echo '</table>';
                    }
                    else
                    {
                        echo '<p>Er zijn geen vakken gevonden</p>';
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
