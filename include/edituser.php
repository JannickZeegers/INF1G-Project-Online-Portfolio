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
        <title>Ons Portfolio - Wijzig gebruiker</title>
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
                $targetId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_user_details($targetId);
                    if($targetData)
                    {
                        if(portfolio_user_is_of_type(array('admin')))
                        {
                            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '">';
                            echo '<h2>' . $targetData['voornaam'] . ' ' . $targetData['achternaam'] . '</h2>';
                            
                            //HIER SUBMIT TROEP
                            if(isset($_POST['submit']))
                            {
                                $gebruikersnaam = filter_input(INPUT_POST, 'gebruikersnaam', FILTER_SANITIZE_STRING);
                                $voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_STRING);
                                $achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_STRING);
                                $email = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_STRING);
                                $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);
                                if($gebruikersnaam && $voornaam && $achternaam && $email &&
                                        ($rol === 'student' || $rol === 'docent' || $rol === 'slb' || $rol === 'admin'))
                                {
                                    if(portfolio_update_user($targetId, $voornaam, $achternaam, $gebruikersnaam, $email, $rol))
                                    {
                                        echo '<p>Gebruiker geupdate</p>';
                                        $targetData = portfolio_get_user_details($targetId);
                                    }
                                    else
                                    {
                                        echo '<p>Gebruiker kon niet worden geupdate</p>';
                                    }
                                }
                                else
                                {
                                    echo '<p>Niet alle velden zijn correct ingevuld!</p>';
                                }
                            }

                            echo '<h3>Gegevens</h3>';
                            echo '<table class="tableLeft">';

                            echo '<tr><th rel="row">' . 'Gebruikers ID' . '</th><td>'
                                    . $targetData['gebruikersId'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Gebruikersnaam' . '</th><td>'
                                    . '<input type="text" name="gebruikersnaam" value="'
                                    . $targetData['gebruikersnaam'] 
                                    . '">'
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Voornaam' . '</th><td>'
                                    . '<input type="text" name="voornaam" value="'
                                    . $targetData['voornaam']
                                    . '">'
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Achternaam' . '</th><td>'
                                    . '<input type="text" name="achternaam" value="'
                                    . $targetData['achternaam']
                                    . '">'
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'E-Mail adres' . '</th><td>'
                                    . '<input type="text" name="eMail" value="'
                                    . $targetData['eMail']
                                    . '">'
                                    . '</td></tr>';
                            /*
                             * TODO: Drop down ipv text field!
                             */
                            /*echo '<tr><th rel="row">' . 'Rol' . '</th><td>'
                                    . '<input type="text" name="rol" value="'
                                    . $targetData['rol']
                                    . '">'
                                    . '</td></tr>';
                            echo '</table>';*/
                            echo '<tr><th rel="row">' . 'Rol' . '</th><td>';
                            echo '<select name="rol">';
                            $rollen = array('student', 'docent', 'slb', 'admin');
                                   /* . '<input type="text" name="rol" value="'
                                    . $targetData['rol']
                                    . '">'*/
                            foreach($rollen as $r)
                            {
                                echo '<option value="' . $r . '"';
                                echo ($r === $targetData['rol']) ? ' selected="selected">' : '>';
                                echo $r . '</option>';
                            }
                            echo '</select>';
                            echo '</td></tr>';
                            echo '</table>';
                            echo '<input type="submit" name="submit" value="Apply">';
                            echo '</form>';
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
