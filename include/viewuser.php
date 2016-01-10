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
        <title>Ons Portfolio - Bekijk materiaal</title>
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
                $matId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                if($matId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    $matData = portfolio_get_material($matId);
                    if($matData)
                    {
                        echo '<h2>' . $matData['naam'] . '</h2>';
                        echo '<p><a href="' . SITE_HTTP_NAME . $matData['bestandsPad'] . '" target="_blank">Download</a></p>';
                        echo '<h3>Gegevens</h3>';
                        echo '<table class="tableLeft">';
                        
                        $eigenaar = portfolio_get_user_details($matData['eigenaarId']);
                        
                        echo '<tr><th rel="row">' . 'Materiaal ID' . '</th><td>' . $matData['materiaalId'] . '</td></tr>';
                        echo '<tr><th rel="row">' . 'Eigenaar' . '</th><td>' . $eigenaar['voornaam'] . ' ' . $eigenaar['achternaam'] . ' (' . $matData['eigenaarId'] . ')' . '</td></tr>';
                        echo '<tr><th rel="row">' . 'Bestandslocatie' . '</th><td>' . $matData['bestandsPad'] . '</td></tr>';
                        echo '<tr><th rel="row">' . 'MIME type' . '</th><td>' . $matData['bestandsType'] . '</td></tr>';
                        $janee = ($matData['isOpenbaar']) ? 'Ja' : 'Nee';
                        echo '<tr><th rel="row">' . 'Openbaar' . '</th><td>' . $janee . '</td></tr>';
                        
                        echo '</table>';
                        
                        echo '<h3>Beoordeling</h3>';
                        
                        $cijferData = portfolio_get_note($matId);
                        if($cijferData)
                        {
                            echo '<table class="tableLeft">';
                            echo '<tr><th rel="row">' . 'Cijfer' . '</th><td>' . $cijferData['cijfer'] . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Gegeven door' . '</th><td>';
                            $bo = portfolio_get_user_details($cijferData['beoordelaarId']);
                            if($bo)
                            {
                                echo $bo['voornaam'] . ' ' . $bo['achternaam'];
                            }
                            else
                            {
                                echo 'Onbekend';
                            }
                            echo '</td></tr>';
                            echo '</table>';
                            if($_SESSION['user']['rol'] == 'slb')
                            {
                                if($_SESSION['user']['gebruikersId'] === $cijferData['beoordelaarId'])
                                {
                                    echo '<p><a href="cijfer.php?material=' . $matId . '">Wijzig cijfer</p>';
                                }
                            }
                        }
                        else
                        {
                            echo '<p>Dit materiaal is nog niet beoordeeld</p>';
                            if($_SESSION['user']['rol'] == 'slb')
                            {
                                echo '<p><a href="cijfer.php?material=' . $matId . '">Geef cijfer</p>';
                            }
                        }
                        
                        if($_SESSION['user']['rol'] == 'student')
                        {
                            if($_SESSION['user']['gebruikersId'] === $matData['eigenaarId'])
                            {
                                echo '<h3>Opties</h3>';
                                //Wijzig materiaal
                                echo '<p><a href="editmaterial.php?material=' . $matId . '">Wijzig materiaal</a></p>';
                                //Alleen verwijderen als er GEEN cijfer is gegeven
                                if(!$cijferData)
                                {
                                    echo '<p><a href="removematerial.php?material=' . $matId . '">Verwijder materiaal</a></p>';
                                }
                            }
                        }
                    }
                    else
                    {
                        echo '<p>Materiaal niet gevonden!</p>';
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
