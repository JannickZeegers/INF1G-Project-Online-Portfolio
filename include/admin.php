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
                
                /*
                 * TODO: Verplaats dit overzicht naar een andere pagina?
                 * Admin pagina links geven naar verschillende pagina's die de nodige overzichten bieden
                 * In FO staat misschien wel welke overzichten we nodig hebben per rol
                 */
                
                /*
                 * TEST VOOR SLB ACCOUNT
                 * Lijst alle materialen, gegroepeerd student
                 */
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
                        echo '<table class="tableLeft">';
                        foreach($mats as $mat)
                        {
                            //echo '<p>' . $mat['materiaalId'] . ' - ' . $mat['naam'] . ' - <a href="cijfer.php?material=' . $mat['materiaalId'] . '">Geef cijfer</a></p>';
                            echo '<tr><td><a href="viewmaterial.php?material=' . $mat['materiaalId'] . '">' . $mat['naam'] . '</a></td></tr>';
                        }
                        echo '</table>';
                    }
                }
                /*
                 * TEST VOOR STUDENT ACCOUNT
                 * Lijst alle materialen van deze student
                 */
                else if($_SESSION['user']['rol'] == 'student')
                {
                    //TEST: Lijst met alle materialen van 'test'
                    echo '<h2>LIJST MATERIALEN</h2>';
                    echo '<hr>';

                    echo '<h3>Jouw materialen</h3>';
                    $mats = portfolio_get_user_materials($_SESSION['user']['gebruikersId']);
                    echo '<table class="tableLeft">';
                    foreach($mats as $mat)
                    {
                        //echo '<p>' . $mat['materiaalId'] . ' - ' . $mat['naam'] . ' - <a href="cijfer.php?material=' . $mat['materiaalId'] . '">Geef cijfer</a></p>';
                        echo '<tr><td><a href="viewmaterial.php?material=' . $mat['materiaalId'] . '">' . $mat['naam'] . '</a></td></tr>';
                    }
                    echo '</table>';
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
