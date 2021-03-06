<?php
include_once 'portfolio.php';
/*
 * Laat een lijst met alle materialen van een bepaalde student zien.
 * Ingelogde student kan alleen eigen materialen zien.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Materialen</title>
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
                
                //Als een student ingelogd is, dan is targetUser de student. Anders pakken we hem via GET
                $targetUser = portfolio_user_is_of_type(array('student')) ? $_SESSION['user']['gebruikersId'] : filter_input(INPUT_GET, 'student', FILTER_VALIDATE_INT);

                if($targetUser)
                {
                    $mats = portfolio_get_user_materials($targetUser);
                    $userData = portfolio_get_user_details($targetUser);
                    if($userData)
                    {
                        echo '<h2>Materialen van ' .$userData['voornaam'] . ' ' . $userData['achternaam'] . '</h2>';
                        if(!portfolio_user_is_of_type(array('student')))
                        {
                            echo '<p><a href="students.php">Terug naar studentenoverzicht</a></p>';
                        }
                        else
                        {
                            echo '<p><a href="upload.php">Upload nieuw materiaal</a></p>';
                        }
                        echo '<hr>';
                    }                    
                    if(count($mats) > 0)
                    {
                        echo '<table class="tableLeft">';
                        foreach($mats as $mat)
                        {
                            echo '<tr><td><a href="viewmaterial.php?material=' . $mat['materiaalId'] . '">' . $mat['naam'] . '</a></td></tr>';
                        }
                        echo '</table>';                        
                    }
                    else
                    {
                        echo '<p>Geen materialen gevonden!</p>';
                    }
                }
                else
                {
                    echo '<p>Student niet gevonden!</p>';
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
