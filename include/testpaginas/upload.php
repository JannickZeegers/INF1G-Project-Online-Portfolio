<?php
include_once "../portfolio.php";
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Upload file</h1>
        <?php
        if(isset($_SESSION['user']))
        {
            echo "<p>Gebruiker: " . $_SESSION['user']['gebruikersnaam'] . "</p>";
            // put your code here
            if(isset($_POST["submit"]))
            {
                $public = 0;
                if(isset($_POST['public']) && $_POST['public'] === "true")
                    $public = true;
                if(portfolio_upload_material($_SESSION['user']['gebruikersId'], 'file', $public))
                {
                    echo '<p>Upload succesvol</p>';
                }
                else
                {
                    echo '<p>FOUT: Upload mislukt!</p>';
                }
            }
            ?>
            <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
                <p>File<br><input type="file" name="file"></p>
                <p>Openbaar zichtbaar?<br><input type="checkbox" name="public" value="true" checked="checked"></p>
                <p><input type='submit' name='submit' value='upload'></p>
            </form>
            <?php
        }
        else
        {
            echo '<p><a href="login.php">Log in om materialen te uploaden</a></p>';
        }
        ?>
    </body>
</html>
