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
                    $messages = portfolio_get_messages();
                    
                        echo "<p>Your inbox:</p>";
                        echo "<table class='tableLeft' width='100%' border='1'>";
                        echo "<tr><th>Recieved by</th><th>Subject</th></tr>";
                        foreach($messages as $m)
                        {                                         
                        echo "<tr><td>{$m['zenderID']}</td>";
                        echo "<tr><td><a href='viewmail.php?material=" . $m['berichtID'] . "'>{$m['onderwerp']}</a></td></tr>"; 
                        }                   
            }           echo "</table>";
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
