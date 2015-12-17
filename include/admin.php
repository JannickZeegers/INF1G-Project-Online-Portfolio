<!DOCTYPE html>
<!--

    Dit is een admin paneel waar een ingelogde gebruiker menus heeft om dingen te doen.
    Bijvoorbeeld een materiaal uploaden, materialen, vakken en cijfers bekijken of dingen beoordelen.
    Ook het gastenboek?

-->
<?php
include_once 'portfolio.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Admin panel</title>
    </head>
    <body>
        <!-- TODO: LAYOUT n SHIT -->
        <?php
        if(isset($_SESSION['user']))
        {
            //Alles
            echo "<h2>Welkom " . $_SESSION['user']['gebruikersnaam'] . "</h2>";
        }
        else
        {
            echo "<h2>Log eerst in!</h2>";
        }
        ?>
    </body>
</html>
