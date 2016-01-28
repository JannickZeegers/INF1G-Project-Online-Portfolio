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
        <title>Ons Portfolio - Vakken van gebruiker</title>
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
                
                $targetUser = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);

                if($targetUser)
                {
                    $subjects = portfolio_get_user_subjects($targetUser);
                    $userData = portfolio_get_user_details($targetUser);
                    if($userData)
                    {
                        echo '<h2>Vakken van ' .$userData['voornaam'] . ' ' . $userData['achternaam'] . '</h2>';
                        //echo '<p><a href="students.php">Terug naar studentenoverzicht</a></p>';
                        if($userData['rol'] != 'student')
                        {
                            echo '<p>Geeft de volgende vakken</p>';
                        }
                        echo '<hr>';
                    }                    
                    if(count($subjects) > 0)
                    {
                        echo '<table class="tableLeft">';
                        foreach($subjects as $sub)
                        {
                            echo '<tr><td><a href="viewnotes.php?student=' . $targetUser . '&subject=' . $sub['vakId'] . '">' . $sub['vaknaam'] . '</a></td></tr>';
                        }
                        echo '</table>';                        
                    }
                    else
                    {
                        echo '<p>Geen vakken gevonden!</p>';
                    }
                }
                else
                {
                    echo '<p>Gebruiker niet gevonden!</p>';
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
