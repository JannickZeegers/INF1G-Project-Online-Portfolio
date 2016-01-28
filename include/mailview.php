<?php
include_once 'portfolio.php';
/*
 * Pagina om een mail te bekijken. Alleen zender of ontvanger kan mail zien.
 */
?>
<!DOCTYPE html>
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
                    $mailData = portfolio_get_message($mailId);
                    if($mailData)
                    {
                        if( (!portfolio_user_is_of_type(array('admin')) && ($mailData['ontvangerId'] == $_SESSION['user']['gebruikersId'] || $mailData['zenderId'] == $_SESSION['user']['gebruikersId']))
                                || portfolio_user_is_of_type(array('admin')))
                        {
                            echo "<h2>Onderwerp: " . htmlentities($mailData['onderwerp']) . "</h2>";
                            
                            //Mail removal code
                            $action = filter_input(INPUT_GET, 'action');
                            switch($action)
                            {
                                case 'remove':  //No confirmation, it just sorta deletes it
                                    if(portfolio_delete_mail_message($mailId)){
                                        echo '<p>Mail verwijderd</p>';
                                    }else{
                                        portfolio_error();
                                    }
                                    break;
                                default:
                                    echo '<p><a href="mailview.php?' . $_SERVER['QUERY_STRING'] . '&action=remove">Verwijderen</a></p>';
                                    break;
                            }
                            //
                            
                            $sender = portfolio_get_user_details($mailData['zenderId']);
                            $reciever = portfolio_get_user_details($mailData['ontvangerId']);
                            echo '<table class="tableLeft"><tr><th rel="row">Zender:</th><td>';
                            echo (count($sender) > 0) ? $sender['voornaam'] . ' ' . $sender['achternaam'] : 'Onbekend';
                            echo '</td></tr><tr><th rel="row">Ontvanger:</th><td>';
                            echo (count($reciever) > 0) ? $reciever['voornaam'] . ' ' . $reciever['achternaam'] : 'Onbekend';
                            echo '</td></tr></table>';
                            
                            echo "<hr><p>" . str_replace("\n", "<br>", htmlentities($mailData['bericht'])) . "</p><hr>";
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
                echo '<p><a href="mailinbox.php">Terug naar inbox</a></p>';
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
