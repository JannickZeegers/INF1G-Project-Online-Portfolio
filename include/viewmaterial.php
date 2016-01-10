<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<!--
    
    Deze pagina laat gegevens van een materiaal zien.
    Welke dit zijn is afhankelijk van wie is ingelogd.
    Daarnaast bevat deze pagina links naar andere paginas die de gebruiker in staat stellen
    acties uit te voeren op dit materiaal, denk aan beoordelen, gegevens aanpassen of het materiaal verwijderen

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bekijk materiaal</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
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
                    //Ingelogd
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    $matData = portfolio_get_material($matId);
                    if($matData)
                    {
                        //Is dit een student? Zo ja, ga alleen verder als hij/zij de eigenaar is van dit materiaal.
                        //Alle andere rollen hebben altijd toegang.
                        if(($_SESSION['user']['rol'] == 'student' && $_SESSION['user']['gebruikersId'] === $matData['eigenaarId']) || $_SESSION['user']['rol'] != 'student')
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

                            /*
                             * Cijfer
                             */
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
                                //if($_SESSION['user']['rol'] == 'slb')
                                if(portfolio_user_is_of_type(array('slb', 'admin')))
                                {
                                    if($_SESSION['user']['gebruikersId'] === $cijferData['beoordelaarId'] || portfolio_user_is_of_type(array('admin')))
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

                            /*
                             * Menu voor student zelf + admin
                             */
                            //if($_SESSION['user']['rol'] == 'student')
                            if(portfolio_user_is_of_type(array('student', 'admin')))
                            {
                                if($_SESSION['user']['gebruikersId'] === $matData['eigenaarId'] || portfolio_user_is_of_type(array('admin')))
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
                            echo '<p>U bent niet gemachtigd dit materiaal te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Materiaal niet gevonden!</p>';
                    }
                }
                echo '<p><a href="admin.php">Ga terug</a></p>';
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
