<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<!--
    Een scherm waarmee een admin een gebruikersaccount aan kan passen.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bewerk materiaal</title>
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
                $targetId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_material($targetId);
                    if($targetData)
                    {
                        if($_SESSION['user']['gebruikersId'] === $targetData['eigenaarId'] || portfolio_user_is_of_type(array('admin')))
                        {
                            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '">';
                            echo '<h2>' . $targetData['naam'] . '</h2>';
                            
                            //HIER SUBMIT TROEP
                            if(isset($_POST['submit']))
                            {
                                $naam = filter_input(INPUT_POST, 'naam');
                                $isPublic = filter_input(INPUT_POST, 'isOpenbaar');
                                if(!empty($naam))
                                {
                                    switch($isPublic)
                                    {
                                        case 0: $isPublic = 0; break;
                                        case 1: $isPublic = 1; break;
                                        default: $isPublic = 0; break;
                                    }
                                    //VAKKEN
                                    $vakken = array();
                                    $vakData = portfolio_get_user_subjects($targetData['eigenaarId']);
                                    foreach($vakData as $vak)
                                    {
                                        $input = filter_input(INPUT_POST, 'vak' . $vak['vakId']);
                                        if($input)
                                        {
                                            $vakken[] = $vak['vakId'];
                                        }
                                    }
                                    //UPDATE 
                                    if(portfolio_update_material($targetId, $naam, $isPublic, $vakken))
                                    {
                                        echo '<p>Materiaal aangepast</p>';
                                        $targetData = portfolio_get_material($targetId);
                                    }
                                    else
                                    {
                                        echo '<p>Kon materiaal niet aanpassen</p>';
                                    }
                                }
                            }

                            echo '<h3>Gegevens</h3>';
                            echo '<table class="tableLeft">';

                            echo '<tr><th rel="row">' . 'Materiaal ID' . '</th><td>'
                                    . $targetData['materiaalId'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Eigenaar ID' . '</th><td>'
                                    . $targetData['eigenaarId'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Bestandspad' . '</th><td>'
                                    . $targetData['bestandsPad'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Bestandstype' . '</th><td>'
                                    . $targetData['bestandsType'] 
                                    . '</td></tr>';
                            echo '<tr><th rel="row">' . 'Naam' . '</th><td>'
                                    . '<input type="text" name="naam" value="'
                                    . $targetData['naam'] 
                                    . '">'
                                    . '</td></tr>';
                            $janee = ($targetData['isOpenbaar']) ? 'Ja' : 'Nee';
                            echo '<tr><th rel="row">' . 'Is openbaar' . '</th><td>';
                            echo '<select name="isOpenbaar">';
                            if($targetData['isOpenbaar'])
                            {
                                echo '<option value="1" selected="selected">Ja</option><option value="0">Nee</option>';
                            }
                            else
                            {
                                echo '<option value="1">Ja</option><option value="0" selected="selected">Nee</option>';
                            }
                            echo '</select>';
                            echo '</td></tr>';
                            /*
                             * Iets met vakken
                             */
                            $vakkenActief = portfolio_get_material_subjects($targetId);
                            echo '<tr><th rel="row">' . 'Vakken' . '</th><td>';
                            $vakken = portfolio_get_user_subjects($targetData['eigenaarId']);
                            foreach($vakken as $r)
                            {
                                echo '<input type="checkbox" name="vak' . $r['vakId'] . '"';
                                foreach($vakkenActief as $va)
                                {
                                    if($r['vakId'] === $va['vakId'])
                                    {
                                        echo ' checked="checked"';
                                        continue;
                                    }
                                }
                                echo '>' . $r['vaknaam'] . '<br>';
                            }
                            echo '</td></tr>';
                            
                            echo '</table>';
                            
                            echo '<input type="submit" name="submit" value="Apply">';
                            echo '</form>';
                            
                            echo '<p><a href="viewmaterial.php?material=' . $targetId . '">Terug</a></p>';
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze pagina te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Materiaal niet gevonden!</p>';
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
