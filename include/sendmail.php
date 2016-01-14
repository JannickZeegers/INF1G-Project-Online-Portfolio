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
                echo "<p><form method='post' action='" . $_SERVER['PHP_SELF'] . "'></p>"
                        . "<p>Send to: <select name='reciever'>";
                        $users = portfolio_get_users();
                        foreach($users as $s)
                        {
                            echo "<option value='" . $s['gebruikersId'] . "'>" . $s['voornaam'] . ' ' . $s['achternaam'] . ':     ' . $s['rol'] . "</option>";
                        }
                        echo "</select></p>";
                echo "<p>Subject: <input type='text' name='reason'></p>";
                echo "<p>Message:</p><p><textarea name='message' rows='40' cols='100'>Nothing to see, no healthkit here!</textarea></p>";
                echo "<p><input type='submit' name='send' value='send'></p>";
                echo "</form>";
                
                if(isset($_POST['send']))
                {
                    echo "<p>Your message has been send!";
                    $user = $_SESSION['user'];
                    $subject = htmlentities($_POST['reason']);
                    $subject = mysqli_real_escape_string($subject);
                    $message = htmlentities($_POST['message']);
                    $message = mysqli_real_escape_string($message);
                }
            }  
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
