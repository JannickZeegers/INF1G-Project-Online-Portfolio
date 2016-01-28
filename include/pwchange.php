<?php
include_once 'portfolio.php';

$wasChanged = false;
$message = '';

if(isset($_POST['submit']))
{
    $curpass = filter_input(INPUT_POST, 'curpass');
    $newpass = filter_input(INPUT_POST, 'newpass');
    $newpass2 = filter_input(INPUT_POST, 'newpass2');
    
    $userId = $_SESSION['user']['gebruikersId'];    //Zolang je niet uitlogt tijdens het veranderen van je wachtwoord is het helemaal prima
    
    if(!empty($curpass) && !empty($newpass) && !empty($newpass2))
    {
        if($newpass === $newpass2)
        {
            /*
             * Bepaal welke methode wordt gebruikt. 0 -> resetpass functie 1 -> code op deze pagina
             */
            if(0)   /// 
            {       ///
            $link = portfolio_connect();
            if($link)
            {
                $sql = "SELECT wachtwoord 
                        FROM " . TABLE_USER . " 
                        WHERE gebruikersId=" . mysqli_real_escape_string($link, $userId);
                $result = mysqli_query($link, $sql);
                if($result !== false)
                {
                    if(($array = mysqli_fetch_assoc($result)) != null)
                    {
                        if(password_verify($curpass, $array['wachtwoord']))
                        {
                            $sql = "UPDATE " . TABLE_USER .
                                    " SET wachtwoord='" . mysqli_real_escape_string($link, password_hash($newpass, PASSWORD_DEFAULT)) .
                                    "' WHERE gebruikersId=" . mysqli_real_escape_string($link, $userId);
                            if(mysqli_query($link, $sql))
                            {
                                $message = 'Wachtwoord aangepast';
                                $wasChanged = true;
                            }
                            else
                            {
                                $message = 'Kon wachtwoord niet veranderen';
                            }
                        }
                        else
                        {
                            $message = 'Oude wachtwoord niet correct';
                        }
                    }
                }
            }
            }       ///
            else    ///
            {       ///
            if(resetpass($userId, $curpass, $newpass))
            {
                $message = 'Wachtwoord aangepast';
                $wasChanged = true;
            }
            else
            {
                $message = 'Er ging iets mis';
            }
            }       ///
        }
        else
        {
            $message = 'Nieuw wachtwoord is niet gelijk ingevuld';
        }
    }
    else
    {
        $message = 'Niet alle velden zijn ingevuld';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Verander wachtwoord</title>
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
                echo "<h2>Verander je wachtwoord</h2>";
                echo '<p>' . $message . '</p>';
                if(!$wasChanged)
                {
                    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                    echo '<p>Huidig wachtwoord <input type="password" name="curpass"></p>';
                    echo '<p>Nieuw wachtwoord <input type="password" name="newpass"></p>';
                    echo '<p>Bevestig nieuw wachtwoord <input type="password" name="newpass2"></p>';
                    echo '<p><input type="submit" value="submit" name="submit"></p>';
                    echo '</form>';
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
