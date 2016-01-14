<?php
include_once "portfolio.php";
?>
<!DOCTYPE html>
<!--
    
    Deze pagina stelt de gebruiker (alleen ingelogde SLBer) in staat een cijfer te geven aan een materiaal.
    Dit kan echter alleen wanneer er nog geen cijfer is gegeven OF de momenteel ingelogde SLBer het eerdere cijfer heeft gegeven.

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Geef cijfer</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <?php include 'inc/header.php'; ?>
            </div>
            <div id="content">
            <h2>Cijfer</h2>
            <?php
            if(portfolio_user_is_of_type(array('slb')))
            {            
                $matId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                if($matId)
                {
                    $matData = portfolio_get_material($matId);
                    if($matData)
                    {
                        echo '<p>Geef cijfer voor ' . $matData['naam'] . '</p>';
                        if(isset($_POST["submit"]))
                        {
                            $cijfer = filter_input(INPUT_POST, 'cijfer', FILTER_VALIDATE_FLOAT);
                            if($cijfer)
                            {
                                if(portfolio_set_note($matId, $cijfer))
                                {
                                    echo '<p>Cijfer gegeven!</p>';
                                }
                                else
                                {
                                    echo '<p>Er ging iets mis!</p>';
                                }
                            }
                        }
                        $huidigCijfer = portfolio_get_note($matId);
                        if($huidigCijfer)
                        {
                            echo '<p>Huidig cijfer is ' . $huidigCijfer['cijfer'] . '</p>';
                        }
                        else
                        {
                            echo '<p>Nog geen cijfer gegeven!</p>';
                        }
                    ?>
                    <form action='<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>' method='post'>
                        <p>Cijfer<br><input type="text" name="cijfer"></p>
                        <p><input type='submit' name='submit' value='bevestig'></p>
                    </form>
                    <?php
                    }
                    else
                    {
                        echo '<p>Materiaal niet gevonden!</p>';
                    }
                }
                echo '<p><a href="viewmaterial.php' . "?" . $_SERVER['QUERY_STRING'] . '">Ga terug</a></p>';
            }
            else
            {
                echo '<p>Niet gemachtigd om te beoordelen</p>';
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
