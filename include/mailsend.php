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
                $subject = '';
                $message = '';
                $recieverId = 1;    //Sorry martijn   			- Geeft niet (Martijn)
                //Boven aan pagina gezet voor makkelijker lezen
                if(isset($_POST['send']))
                {
                    $dbConnect = portfolio_connect();
                    $subject = filter_input(INPUT_POST, 'subject');
                    $message = filter_input(INPUT_POST, 'message');
                    $recieverId = filter_input(INPUT_POST, 'reciever');
                    
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
                                echo "<p style='color: red'>Seriously, how did you do that?</p>";
                            }
                        }
                        else
                        { 
                            $senderId = $_SESSION['user']['gebruikersId'];
                            if(portfolio_send_message($senderId, $recieverId, $subject, $message))
                            {
                                echo '<p>Bericht verzonden</p>';
                            }
                            else
                            {
                                echo '<p>Kon bericht niet verzenden</p>';
                            }
                        }
                    }                   
                }
                
                echo "<p><form method='post' action='" . $_SERVER['PHP_SELF'] . "'></p>"
                        . "<p>Send to: <select name='reciever'>";
                        $users = portfolio_get_users();
                        foreach($users as $s)
                        {
                            if($recieverId === $s['gebruikersId']){
                                echo "<option value='" . $s['gebruikersId'] . "' selected='selected'>" . $s['voornaam'] . ' ' . $s['achternaam'] . ':     ' . $s['rol'] . "</option>";
                            }else{
                                echo "<option value='" . $s['gebruikersId'] . "'>" . $s['voornaam'] . ' ' . $s['achternaam'] . ':     ' . $s['rol'] . "</option>";
                            }
                            
                        }
                        echo "</select></p>";
                echo "<p>Subject: <input type='text' name='subject' value='" . htmlentities($subject) . "'> (max 155 characters)</p>";
                //Vervang newlines met breaks zodat het goed wordt weergeven!
                echo "<p>Message :</p><p><textarea name='message' rows='20' cols='100'>" . htmlentities($message) . "</textarea></p>";
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
