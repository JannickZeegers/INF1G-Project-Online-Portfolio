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
        <title>Ons Portfolio - Verwijder cijfer</title>
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
                //$matId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                $matId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                if($matId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    $matData = portfolio_get_material($matId);
                    $noteData = portfolio_get_note($matId);
                    if($matData && $noteData)
                    {
                        echo '<h2>Verwijder cijfer voor ' . $matData['naam'] . '</h2>';
                        
                        /*
                         * Checks + verwijderen van materiaal.
                         */
                        if(portfolio_user_is_of_type(array('admin')) || $_SESSION['user']['gebruikersId'] == $noteData['beoordelaarId'])
                        {
                            $pwCorrect = false;
                            $deleted = false;
                            if(isset($_POST['submit']) && isset($_SESSION['user']) && $matId)
                            {
                                $userId = $_SESSION['user']['gebruikersId'];
                                $userPass = filter_input(INPUT_POST, 'userPass');
                                $link = portfolio_connect();
                                if($link)
                                {
                                    $sql = "SELECT * FROM " . TABLE_USER . " WHERE gebruikersId='" . mysqli_real_escape_string($link, $userId) . "'";
                                    $result = mysqli_query($link, $sql);
                                    if($result !== false)
                                    {
                                         if(($array = mysqli_fetch_assoc($result)) != null)
                                        {
                                            if(password_verify($userPass, $array['wachtwoord']))
                                            {
                                                $pwCorrect = true;
                                                $deleted = portfolio_delete_note($matId);
                                            }
                                        }
                                    }
                                }
                            }

                            /*
                             * Wachtwoord prompt + teruggave info over succes van verwijderen
                             */
                            if(!$pwCorrect)
                            {
                                echo '<h3>Typ hieronder uw wachtwoord in om het cijfer te verwijderen</h3>';
                                ?>
                                <form action='<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']?>' method='post' enctype="multipart/form-data">
                                    <p>Wachtwoord:<br><input type='password' name='userPass'></p>
                                    <p><input type='submit' name='submit' value='login'></p>
                                </form>
                                <?php
                            }
                            else if($deleted)
                            {
                                echo '<p>Cijfer verwijderd</p>';
                            }
                            else
                            {
                                echo '<p>Kon cijfer niet verwijderen</p>';
                            }
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd dit cijfer te verwijderen</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Dit materiaal bestaat niet of het heeft geen cijfer!</p>';
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
