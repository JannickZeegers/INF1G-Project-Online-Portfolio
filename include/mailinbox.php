<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - inbox</title>
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
                    $messages = portfolio_get_user_messages($_SESSION['user']['gebruikersId']);
                    echo "<h3>Inbox:</h3>";
                    echo "<table class='tableLeft' width='100%' border='1'>";
                    echo "<tr><th>Zender</th><th>Onderwerp</th></tr>";
                    foreach($messages as $m)
                    {
                        $o = portfolio_get_user_details($m['zenderId']);
                        if(count($o) < 1)
                        {
                            $o['voornaam'] = 'Onbekend';
                            $o['achternaam'] = '';
                        }
                        echo "<tr><td>{$o['voornaam']} {$o['achternaam']}</td>";
                        echo "<td><a href='mailview.php?mail=" . $m['berichtId'] . "'>{$m['onderwerp']}</a></td></tr>"; 
                    }
                    echo "</table>";
                    echo "<p><hr></p>";
                        
                    $messages = portfolio_get_send_messages($_SESSION['user']['gebruikersId']);
                    
                    echo "<h3>Verzonden berichten:</h3>";
                    echo "<table class='tableLeft' width='100%' border='1'>";
                    echo "<tr><th>Ontvanger</th><th>Onderwerp</th></tr>";
                    foreach($messages as $m)
                    {                     
                        $o = portfolio_get_user_details($m['ontvangerId']);
                        if(count($o) < 1)
                        {
                            $o['voornaam'] = 'Onbekend';
                            $o['achternaam'] = '';
                        }
                        echo "<tr><td>{$o['voornaam']} {$o['achternaam']}</td>";
                        echo "<td><a href='mailview.php?mail=" . $m['berichtId'] . "'>{$m['onderwerp']}</a></td></tr>"; 
                    }
                    echo "</table>"; 
                    echo "<p><hr></p>";
                    echo "<h3><a href='mailsend.php'> Nieuw bericht opstellen</a></h3>";
            }           
                        
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
