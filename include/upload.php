<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
<!--
    
    Pagina voor uploaden van nieuwe materialen.
    Mag nu alleen gedaan worden door een ingelogde STUDENT. 

    TODO: (Check FO of dit gedrag correct is)

-->
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
