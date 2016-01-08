<?php
include_once "portfolio.php";
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
        <title>Ons Portfolio - Geef cijfer</title>
        <link href="css/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
        <h1>Cijfer</h1>
        <?php
        if(isset($_SESSION['user']))
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
        }
        else
        {
            echo '<p><a href="login.php">Log in om te beoordelen</a></p>';
        }
        ?>
        </div>
    </body>
</html>
