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
                            if($userData['rol'] != 'student')
                            {
                                //Geen link
                                echo '<tr><td>' . $sub['vaknaam'] . '</td></tr>';
                            }
                            else
                            {
                                //Wel link
                                echo '<tr><td><a href="viewnotes.php?student=' . $targetUser . '&subject=' . $sub['vakId'] . '">' . $sub['vaknaam'] . '</a></td></tr>';
                            }
                        }
                        echo '</table>';
                    }
                    else
                    {
                        echo '<p>Geen vakken gevonden!</p>';
                    }
                    if(portfolio_user_is_of_type(array('admin')))
                    {
                        echo '<hr>';
                        echo '<p></p>';
                        echo '<h3>Voeg vak toe aan gebruiker</h3>';
                        $allSubjects = portfolio_get_subjects();
                        if(count($allSubjects) > 0)
                        {
                            echo '<table class="tableLeft">';
                            foreach($allSubjects as $sub)
                            {
                                echo '<tr><td><a href="addsubjecttouser.php?user=' . $targetUser . '&subject=' . $sub['vakId'] . '" target="_blank">' . $sub['vaknaam'] . '</a></td></tr>';
                            }
                            echo '</table>';
                        }
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
