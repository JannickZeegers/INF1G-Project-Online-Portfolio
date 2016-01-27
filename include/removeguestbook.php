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
        <title>Ons Portfolio - Verwijder gastenboek bericht</title>
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
                //$msgId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                $msgId = filter_input(INPUT_GET, 'message', FILTER_VALIDATE_INT);
                if($msgId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    $msgData = portfolio_get_guestbook_message($msgId);
                    if($msgData)
                    {
                        echo '<h2>Verwijderen gastenboek bericht</h2>';
                        /*
                         * Checks + verwijderen van materiaal.
                         */
                        if($_SESSION['user']['gebruikersId'] === $msgData['ontvangerId'] || portfolio_user_is_of_type(array('admin')))
                        {
                            $pwCorrect = false;
                            $deleted = false;
                            if(isset($_POST['submit']) && isset($_SESSION['user']) && $msgId)
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
                                                $deleted = portfolio_delete_guestbook_message($msgId);
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
                                echo '<h3>Typ hieronder uw wachtwoord in om het bericht te verwijderen</h3>';
                                ?>
                                <form action='<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']?>' method='post' enctype="multipart/form-data">
                                    <p>Wachtwoord:<br><input type='password' name='userPass'></p>
                                    <p><input type='submit' name='submit' value='login'></p>
                                </form>
                                <?php
                            }
                            else if($deleted)
                            {
                                echo '<p>Bericht verwijderd</p>';
                            }
                            else
                            {
                                echo '<p>Kon bericht niet verwijderen</p>';
                            }
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd dit bericht te verwijderen</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Bericht niet gevonden!</p>';
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
