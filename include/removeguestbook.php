<?php
include_once 'portfolio.php';
/*
 * Pagina die het verwijderen van een gastenboekbericht uitvoert
 * Zie ook guestbook.php
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Verwijder gastenboek bericht</title>
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
                //$msgId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                $msgId = filter_input(INPUT_GET, 'message', FILTER_VALIDATE_INT);
                if($msgId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    $msgData = portfolio_get_guestbook_message($msgId);
                    if($msgData)
                    {
                        echo '<h2>Verwijderen gastenboek bericht</h2>';
                        /*
                         * Checks + verwijderen van materiaal.
                         */
                        if($_SESSION['user']['gebruikersId'] === $msgData['ontvangerId'] || portfolio_user_is_of_type(array('admin')))
                        {
                            if(portfolio_delete_guestbook_message($msgId))
                            {
                                echo '<p>Bericht verwijderd</p>';
                            }
                            else
                            {
                                echo '<p>Kon bericht niet verwijderen</p>';
                            }
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd dit bericht te verwijderen</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Bericht niet gevonden!</p>';
                    }
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
