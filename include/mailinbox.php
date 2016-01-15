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
                    $messages = portfolio_get_messages($_SESSION['user']['gebruikersId']);
                    $users = portfolio_get_users();
                    
                        echo "<p>Your inbox:</p>";
                        echo "<table class='tableLeft' width='100%' border='1'>";
                        echo "<tr><th>Recieved by</th><th>Subject</th></tr>";
                        foreach($messages as $m)
                        {                                         
                        echo "<tr><td>{$m['zenderID']}</td>";
                        echo "<td><a href='viewmail.php?mail=" . $m['berichtID'] . "'>{$m['onderwerp']}</a></td></tr>"; 
                        }
                        echo "</table>";
                        echo "<p><hr></p>";
                        
                    $messages = portfolio_get_send_messages($_SESSION['user']['gebruikersId']);
                    
                        echo "<p>Your send messages:</p>";
                        echo "<table class='tableLeft' width='100%' border='1'>";
                        echo "<tr><th>Send to</th><th>Subject</th></tr>";
                        foreach($messages as $m)
                        {                                         
                        echo "<tr><td>{$m['ontvangerID']}</td>";
                        echo "<td><a href='viewmail.php?mail=" . $m['berichtID'] . "'>{$m['onderwerp']}</a></td></tr>"; 
                        }
                        echo "</table>";
            }           
                        
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
