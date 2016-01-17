<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - sendMail</title>
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
                //Boven aan pagina gezet voor makkelijker lezen
                if(isset($_POST['send']))
                {
                    $dbConnect = portfolio_connect();                    
                    $subject = htmlentities($_POST['reason']);
                    $subject = mysqli_real_escape_string($dbConnect, $subject);
                    $message = htmlentities($_POST['message']);
                    $message = mysqli_real_escape_string($dbConnect, $message);
                    
                    if(empty($subject) || empty($message))
                    {
                        echo "U heeft geen onderwerp of bericht ingevult.";
                    }
                    else
                    {
                        if(strlen($subject) > 155 || strlen($message) > 65535)
                        {
                            if(strlen($subject) > 155)
                            {
                                echo "<p style='color: red'>Your subject is too long. (max 155 characters)</p>";  
                            }
                            else
                            {
                                echo "<p style='color: red'>Your message is to long. (max 65535 characters)</p>";
                            }
                        }
                        else
                        {
                            /*
                             * TODO: Filter input
                             */
                            $recieverId = $_POST['reciever'];
                            $senderId = $_SESSION['user']['gebruikersId'];
                            //Getallen bij een insert/where e.d. niet tussen '' zetten
                            $SQLstring = "INSERT INTO " . TABLE_MESSAGE . " VALUES(NULL, $senderId, $recieverId , '$subject' , '$message')";
                            $QueryResult = mysqli_query($dbConnect, $SQLstring);
                            echo "<p>Your message has been send!</p>";
                        }
                    }                   
                }
                
                echo "<p><form method='post' action='" . $_SERVER['PHP_SELF'] . "'></p>"
                        . "<p>Send to: <select name='reciever'>";
                        $users = portfolio_get_users();
                        foreach($users as $s)
                        {
                            echo "<option value='" . $s['gebruikersId'] . "'>" . $s['voornaam'] . ' ' . $s['achternaam'] . ':     ' . $s['rol'] . "</option>";
                        }
                        echo "</select></p>";
                echo "<p>Subject: <input type='text' name='reason'> (max 155 characters)</p>";                              
                echo "<p>Message :</p><p><textarea name='message' rows='40' cols='100'></textarea></p>";
                echo "<p><input type='submit' name='send' value='send'></p>";
                echo "</form>";
            }  
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
