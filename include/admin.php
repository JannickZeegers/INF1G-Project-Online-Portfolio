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
        <title>Ons Portfolio - Admin panel</title>
    </head>
    <body>
        <!-- TODO: EVERYTHING -->
        <?php
        if(isset($_SESSION['user']))
        {
            //Alles
            echo "<h2>Welkom " . $_SESSION['user']['gebruikersnaam'] . "</h2>";
            if($_SESSION['user']['rol'] == 'slb')
            {
                //TEST: Lijst met alle materialen van 'test'
                echo '<h2>LIJST MATERIALEN</h2>';
                echo '<hr>';
                $mats = portfolio_get_user_materials(1);
                foreach($mats as $mat)
                {
                    echo '<p>' . $mat['materiaalId'] . ' - ' . $mat['naam'] . '</p>';
                }
            }
        }
        else
        {
            echo "<h2>Log eerst in!</h2>";
        }
        ?>
    </body>
</html>
