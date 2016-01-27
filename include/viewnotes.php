<?php
include_once 'portfolio.php';
?>
<!DOCTYPE html>
<!--
    Pagina waarop een lijst met cijfers van een student wordt weergeven.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Bekijk cijfers</title>
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
                $targetId = filter_input(INPUT_GET, 'student', FILTER_VALIDATE_INT);
                if($targetId)
                {
                    //Alles
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    $targetData = portfolio_get_user_details($targetId);
                    if($targetData)
                    {
                        if(($targetData['rol'] === 'student' && portfolio_user_is_of_type(array('slb', 'docent')))
                            || portfolio_user_is_of_type(array('admin'))
                            || $targetId == $_SESSION['user']['gebruikersId'])
                        {
                            echo '<h2>' . $targetData['voornaam'] . ' ' . $targetData['achternaam'] . '</h2>';
                            echo '<h3>Cijfers</h3>';
                            $notes = portfolio_get_student_notes_ext($targetId);
                            if(count($notes) > 0)
                            {
                                echo '<table class="tableLeft">';
                                echo '<tr><th rel="col">naam materiaal</th><th rel="col">verbonden vakken</th><th rel="col">cijfer</th></tr>';
                                
                                foreach($notes as $n)
                                {
                                    $v = portfolio_get_material_subjects($n['materiaalId']);
                                    echo '<tr>';
                                    //naam
                                    echo '<td><a href="viewmaterial.php?material=' . $n['materiaalId'] . '">' . $n['naam'] . '</a></td>';
                                    //vakken
                                    echo '<td>';
                                    for($i = 0; $i < count($v); $i++)
                                    {
                                        echo $v[$i]['vaknaam'];
                                        if($i !== count($v) - 1){
                                            echo ', ';
                                        }
                                    }
                                    echo '</td>';
                                    //cijfer
                                    echo '<td>' . $n['cijfer'] . '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                            }
                            else
                            {
                                echo '<p>Geen cijfers gevonden</p>';
                            }
                            
                        }
                        else
                        {
                            echo '<p>U bent niet gemachtigd deze pagina te bekijken</p>';
                        }
                    }
                    else
                    {
                        echo '<p>Gebruiker niet gevonden!</p>';
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
