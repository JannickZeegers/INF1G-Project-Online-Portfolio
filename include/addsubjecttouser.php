<?php
include_once 'portfolio.php';
/*
 * Pagina waarop een vak aan een gebruiker wordt gekoppeld.
 * Mag alleen gedaan worden door een admin.
 * Deze pagina wordt alleen gelinkt door usersubjects.php
 * 
 * Opmerking:
 * bij user van -1 wordt het vak aan alle STUDENTEN toegevoegd.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ons Portfolio - Vakken van gebruiker</title>
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
            if(portfolio_user_is_of_type(array('admin')))
            {
                //Alles
                echo "<h2>Welkom " . $_SESSION['user']['voornaam'] . " " . $_SESSION['user']['achternaam'] . "</h2>";
                
                $user = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                $subject = filter_input(INPUT_GET, 'subject', FILTER_VALIDATE_INT);
                
                if($user && $subject)
                {
                    if($user < 0)   //Voeg toe aan alle studenten
                    {
                        $students = portfolio_get_students();
                        foreach($students as $s)
                        {
                            if(portfolio_add_user_subject($s['gebruikersId'], $subject))
                            {
                                echo '<p>Vak toegevoegd aan student ' . $s['voornaam'] . ' ' . $s['achternaam'] . '</p>';
                            }
                        }
                    }
                    else    //Voeg aan een gebruiker toe
                    {
                        if(portfolio_add_user_subject($user, $subject))
                        {
                            echo '<p>Vak toegevoegd aan gebruiker!</p>';
                        }
                        else
                        {
                            echo '<p>Kon vak niet toevoegen! Mogelijk is dit vak al aan de gebruiker toegewezen!</p>';
                        }
                    }
                }
            }
            else
            {
                echo "<h2>Log eerst in!</h2>";
            }
            ?>
            </div>
            <div id="footer">
                INF1G - 2016
            </div>
        </div>
    </body>
</html>
