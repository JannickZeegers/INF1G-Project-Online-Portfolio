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
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!-- TODO: EVERYTHING -->
        <div id="container">
        <?php
        if(isset($_SESSION['user']))
        {
            //Alles
            echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
            if($_SESSION['user']['rol'] == 'slb')
            {
                //TEST: Lijst met alle materialen van 'test'
                echo '<h2>LIJST MATERIALEN</h2>';
                echo '<hr>';
                
                $students = portfolio_get_students();
                foreach($students as $s)
                {
                    echo '<h3>' . $s['voornaam'] . ' ' . $s['achternaam'] . '</h3>';
                    $mats = portfolio_get_user_materials($s['gebruikersId']);
                    foreach($mats as $mat)
                    {
                        echo '<p>' . $mat['materiaalId'] . ' - ' . $mat['naam'] . ' - <a href="cijfer.php?material=' . $mat['materiaalId'] . '">Geef cijfer</a></p>';
                    }
                }
            }
            else if($_SESSION['user']['rol'] == 'student')
            {
                //TEST: Lijst met alle materialen van 'test'
                echo '<h2>LIJST MATERIALEN</h2>';
                echo '<hr>';
                
                echo '<h3>Jouw materialen</h3>';
                $mats = portfolio_get_user_materials($_SESSION['user']['gebruikersId']);
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
        </div>
    </body>
</html>
