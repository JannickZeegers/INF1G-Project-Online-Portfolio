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
        <title>Ons Portfolio - Bekijk mail</title>
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
                $mailId = filter_input(INPUT_GET, 'mail', FILTER_VALIDATE_INT);
                if($mailId)
                {
                    //Ingelogd
                    //Todo: maak functie
                    $mailData = portfolio_get_message($mailId);
                    if($mailData)
                    {
                        //Is dit geen admin? Zo ja, ga alleen verder als hij/zij de eigenaar is van dit materiaal.
                        //admin heeft altijd toegang.
                        //if(($_SESSION['user']['rol'] == 'student' && ($_SESSION['user']['gebruikersId'] === $mailData['ontvangerId'] || $_SESSION['user']['gebruikersId'] === $mailData['zenderId'])) || $_SESSION['user']['rol'] != 'student')
                        if( (!portfolio_user_is_of_type(array('admin')) && ($mailData['ontvangerId'] == $_SESSION['user']['gebruikersId'] || $mailData['zenderId'] == $_SESSION['user']['gebruikersId']))
                                || portfolio_user_is_of_type(array('admin')))
                        {
                            /*
                             * TODO: Layout + zender en ontvanger info
                             */
                            echo "<h2>" . $mailData['onderwerp'] . "</h2>";
                            echo "<p>" . $mailData['bericht'] . "</p>";
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze mail te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Mail niet gevonden!</p>';
                    }
                }
                echo '<p><a href="mailinbox.php">Ga terug</a></p>';
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
