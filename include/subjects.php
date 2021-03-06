<?php
include_once 'portfolio.php';
/*
 * Geeft een lijst van alle vakken weer en kan een nieuw vak aanmaken.
 * Alleen voor admin.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Vakken</title>
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
                if(portfolio_user_is_of_type(array('admin')))
                {
                    echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                    
                    if(isset($_POST['submit']))
                    {
                        $naam = filter_input(INPUT_POST, 'vaknaam', FILTER_SANITIZE_STRING);
                        if($naam)
                        {
                            if(strlen($naam) <= 45)
                            {
                                $id = portfolio_add_subject($naam);
                                if($id)
                                {
                                    echo '<p>Vak ' . $naam . ' aangemaakt met id ' . $id . '</p>';
                                }
                            }
                            else
                            {
                                echo '<p>Naam te lang!</p>';
                            }
                        }
                        else
                        {
                            echo '<p>Vul a.u.b. een naam in</p>';
                        }
                    }
                    
                    ?>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <p>Naam van vak (max 45 karakters)</p>
                    <input type="text" value="" name="vaknaam">
                    <input type="submit" value="Maak aan" name="submit">
                </form>
                <?php
                    echo '<hr>';
                    echo '<h3>Lijst vakken</h3>';
                    $vakken = portfolio_get_subjects();
                    if(count($vakken) > 0)
                    {
                        echo '<table class="tableLeft">';
                        echo '<tr><th rel="col">vak id</th><th rel="col">naam</td><th rel="col"></th><th rel="col"></th></tr>';
                        foreach($vakken as $vak)
                        {
                            echo '<tr><td>' . $vak['vakId'] . '</td><td>' . $vak['vaknaam'] . '</td><td><a href="removesubject.php?subject=' . $vak['vakId'] . '" target="_blank">verwijder</a></td><td><a href="addsubjecttouser.php?user=-1&subject=' . $vak['vakId'] . '" target="_blank">ken toe aan alle studenten</a></tr>';
                        }
                        echo '</table>';
                    }
                    else
                    {
                        echo '<p>Er zijn geen vakken gevonden</p>';
                    }
                }
                else
                {
                    echo '<p><a href="admin.php">Ga terug</a></p>';
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
