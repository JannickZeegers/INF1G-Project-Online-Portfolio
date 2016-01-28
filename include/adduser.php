<?php
include_once 'portfolio.php';
/*
 * Deze pagina stelt een admin in staat om een nieuwe gebruikersaccount aan te maken
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Nieuwe gebruiker</title>
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
                if(portfolio_user_is_of_type(array('admin')))
                {
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    if(isset($_POST['submit']))
                    {
                        $gebruikersnaam = filter_input(INPUT_POST, 'gebruikersnaam', FILTER_SANITIZE_STRING);
                        $voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_STRING);
                        $achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_STRING);
                        $wachtwoord = filter_input(INPUT_POST, 'wachtwoord', FILTER_SANITIZE_STRING);
                        $email = filter_input(INPUT_POST, 'eMail', FILTER_VALIDATE_EMAIL);
                        $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);
                        if($gebruikersnaam && $voornaam && $achternaam && $email &&
                                ($rol === 'student' || $rol === 'docent' || $rol === 'slb' || $rol === 'admin'))
                        {
                            $id = portfolio_register_old($gebruikersnaam, $wachtwoord, $email, $voornaam, $achternaam, $rol);
                            if($id)
                            {
                                echo '<p>Gebruiker aangemaakt</p>';
                                echo '<p><a href="viewuser.php?user=' . $id . '">bekijk</a></p>';
                            }
                            else
                            {
                                echo '<p>Gebruiker kon niet worden aangemaakt</p>';
                            }
                        }
                        else
                        {
                            echo '<p>Niet alle velden zijn correct ingevuld!</p>';
                        }
                    }
                    
                    ?>
                <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
                    <p>Voornaam:<br><input type='text' name='voornaam'></p>
                    <p>Achternaam:<br><input type='text' name='achternaam'></p>
                    <p>Gebruikersnaam:<br><input type='text' name='gebruikersnaam'></p>
                    <p>Wachtwoord:<br><input type='password' name='wachtwoord'></p>
                    <p>Email:<br><input type='text' name='eMail'></p>
                    <p>Rol:
                    <?php
                    echo '<select name="rol">';
                    $rollen = array('student', 'docent', 'slb', 'admin');
                           /* . '<input type="text" name="rol" value="'
                            . $targetData['rol']
                            . '">'*/
                    foreach($rollen as $r)
                    {
                        echo '<option value="' . $r . '"';
                        echo ($r === 'student') ? ' selected="selected">' : '>';
                        echo $r . '</option>';
                    }
                    echo '</select>';
                    ?>
                    </p>
                    <p><input type='submit' name='submit' value='Maak aan'></p>
                </form>
                <?php
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
