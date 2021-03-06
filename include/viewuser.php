<?php
include_once 'portfolio.php';
/*
 * Pagina waarop gegevens van een gebruiker te zien zijn.
 * Niet zichtbaar voor studenten.
 * Admin heeft optie tot bewerken.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bekijk gebruiker</title>
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
                $targetId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_user_details($targetId);
                    if($targetData)
                    {
                        if(($targetData['rol'] === 'student' && portfolio_user_is_of_type(array('slb', 'docent')))
                            || portfolio_user_is_of_type(array('admin')))
                        {
                            echo '<h2>' . $targetData['voornaam'] . ' ' . $targetData['achternaam'] . '</h2>';
                            echo '<h3>Gegevens</h3>';
                            echo '<table class="tableLeft">';

                            echo '<tr><th rel="row">' . 'Gebruikers ID' . '</th><td>' . $targetData['gebruikersId'] . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Voornaam' . '</th><td>' . $targetData['voornaam'] . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Achternaam' . '</th><td>' . $targetData['achternaam'] . '</td></tr>';
                            echo '<tr><th rel="row">' . 'E-Mail adres' . '</th><td>' . $targetData['eMail'] . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Rol' . '</th><td>' . $targetData['rol'] . '</td></tr>';

                            echo '</table>';
                            
                            if($targetData['rol'] === 'student' || $targetData['rol'] === 'docent' || $targetData['rol'] === 'slb')
                            {
                                echo '<h3>Opties</h3>';
                                echo '<p><a href="usersubjects.php?user=' . $targetId . '">Overzicht vakken</a></p>';
                            }
                            if($targetData['rol'] === 'student')
                            {
                                echo '<p><a href="viewnotes.php?student=' . $targetId . '">Overzicht cijfers</a></p>';
                                echo '<p><a href="viewmaterials.php?student=' . $targetId . '">Overzicht materialen</a></p>';
                            }
                            
                            if(portfolio_user_is_of_type(array('admin')))
                            {
                                echo '<h3>Administratie</h3>';
                                echo '<p><a href="guestbook.php?user=' . $targetId . '">Bekijk gastenboek gebruiker</a></p>';
                                echo '<p><a href="edituser.php?user=' . $targetId . '">Wijzig gebruiker</a></p>';
                                echo '<p><a href="removeuser.php?user=' . $targetId . '" target="_blank">Verwijder gebruiker</a></p>';
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
