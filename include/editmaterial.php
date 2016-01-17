<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<!--
    Een scherm waarmee een admin een gebruikersaccount aan kan passen.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bewerk materiaal</title>
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
                $targetId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_material($targetId);
                    if($targetData)
                    {
                        if($_SESSION['user']['gebruikersId'] === $targetData['eigenaarId'] || portfolio_user_is_of_type(array('admin')))
                        {
                            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '">';
                            echo '<h2>' . $targetData['naam'] . '</h2>';
                            
                            //HIER SUBMIT TROEP
                            if(isset($_POST['submit']))
                            {
                                /*
                                 * TODO: Deze meuk
                                 */
                                /*$gebruikersnaam = filter_input(INPUT_POST, 'gebruikersnaam', FILTER_SANITIZE_STRING);
                                $voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_STRING);
                                $achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_STRING);
                                $email = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_STRING);
                                $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);
                                if($gebruikersnaam && $voornaam && $achternaam && $email &&
                                        ($rol === 'student' || $rol === 'docent' || $rol === 'slb' || $rol === 'admin'))
                                {
                                    if(portfolio_update_user($targetId, $voornaam, $achternaam, $gebruikersnaam, $email, $rol))
                                    {
                                        echo '<p>Gebruiker aangepast</p>';
                                        $targetData = portfolio_get_user_details($targetId);
                                    }
                                    else
                                    {
                                        echo '<p>Gebruiker kon niet worden aangepast</p>';
                                    }
                                }
                                else
                                {
                                    echo '<p>Niet alle velden zijn correct ingevuld!</p>';
                                }*/
                            }

                            echo '<h3>Gegevens</h3>';
                            echo '<table class="tableLeft">';

                            echo '<tr><th rel="row">' . 'Materiaal ID' . '</th><td>'
                                    . $targetData['materiaalId'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Eigenaar ID' . '</th><td>'
                                    . $targetData['eigenaarId'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Bestandspad' . '</th><td>'
                                    . $targetData['bestandsPad'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Bestandstype' . '</th><td>'
                                    . $targetData['bestandsType'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Naam' . '</th><td>'
                                    . '<input type="text" name="naam" value="'
                                    . $targetData['naam'] 
                                    . '">'
                                    . '</td></tr>';
                            $janee = ($targetData['isOpenbaar']) ? 'Ja' : 'Nee';
                            echo '<tr><th rel="row">' . 'Is openbaar' . '</th><td>';
                            echo '<select name="isOpenbaar">';
                            if($targetData['isOpenbaar'])
                            {
                                echo '<option value="1" selected="selected">Ja</option><option value="0">Nee</option>';
                            }
                            else
                            {
                                echo '<option value="1">Ja</option><option value="0" selected="selected">Nee</option>';
                            }
                            echo '</select>';
                            echo '</td></tr>';
                            /*
                             * TODO: Iets met vakken
                             */
                            echo '</table>';
                            
                            echo '<input type="submit" name="submit" value="Apply">';
                            echo '</form>';
                            
                            echo '<p><a href="viewmaterial.php?material=' . $targetId . '">Terug</a></p>';
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze pagina te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Materiaal niet gevonden!</p>';
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
