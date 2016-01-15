<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<!--
    Pagina waarop een lijst met cijfers van een student wordt weergeven.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bekijk cijfers</title>
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
                $targetId = filter_input(INPUT_GET, 'student', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_user_details($targetId);
                    if($targetData)
                    {
                        if(($targetData['rol'] === 'student' && portfolio_user_is_of_type(array('slb', 'docent')))
                            || portfolio_user_is_of_type(array('admin'))
                            || $targetId == $_SESSION['user']['gebruikersId'])
                        {
                            echo '<h2>' . $targetData['voornaam'] . ' ' . $targetData['achternaam'] . '</h2>';
                            echo '<h3>Cijfers</h3>';
                            $notes = portfolio_get_student_notes($targetId);
                            if(count($notes) > 0)
                            {
                                echo '<table class="tableLeft">';
                                echo '<tr><th rel="col">naam materiaal</th><th rel="col">cijfer</th></tr>';
                                foreach($notes as $n)
                                {
                                    $m = portfolio_get_material($n['materiaalId']);
                                    echo '<tr>';
                                    echo '<td><a href="viewmaterial.php?material=' . $m['materiaalId'] . '">' . $m['naam'] . '</a></td>';
                                    echo '<td>' . $n['cijfer'] . '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                            }
                            else
                            {
                                echo '<p>Geen cijfers gevonden</p>';
                            }
                            
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze pagina te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Gebruiker niet gevonden!</p>';
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
