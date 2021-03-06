<?php
include_once "portfolio.php";
/*
 * Deze pagina heeft een form voor het uploaden van een nieuw materiaal.
 * Alleen een student kan materialen uploaden.
 * Na uploaden komt er een link om de materiaalgegevens te bekijken (en aan te passen)
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Upload</title>
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
                <h2>Upload materiaal</h2>
                <?php
                if(isset($_SESSION['user']))
                {
                    if($_SESSION['user']['rol'] === 'student')
                    {
                        if(isset($_POST["submit"]))
                        {
                            $public = 0;
                            if(isset($_POST['public']) && $_POST['public'] === "true")
                                $public = true;
                            $id = portfolio_upload_material($_SESSION['user']['gebruikersId'], 'file', $public);
                            if($id)
                            {
                                echo '<p>Upload succesvol</p>';
                                echo '<p><a href="viewmaterial.php?material=' . $id . '">Bekijk</a></p>';
                            }
                            else
                            {
                                echo '<p>FOUT: Upload mislukt!</p>';
                            }
                        }
                        ?>
                        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
                            <p>File<br><input type="file" name="file"></p>
                            <p><span title="Dit wil zeggen dat iedereen het materiaal op kan roepen via getmaterial.php. Laat dit aan als je van plan bent het materiaal hiermee op te halen vanaf een andere pagina.">Openbaar zichtbaar?</span><br><input type="checkbox" name="public" value="true" checked="checked"></p>
                            <p><input type='submit' name='submit' value='upload'></p>
                        </form>
                    <?php
                    }
                    else
                    {
                        echo '<p>Alleen studenten kunnen materialen uploaden</p>';
                    }
                    
                }
                else
                {
                    echo '<p><a href="login.php">Log in om materialen te uploaden</a></p>';
                }
                ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
