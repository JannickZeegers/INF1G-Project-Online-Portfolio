<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * afblijven AUB
 */

/*
 * Registreer een gebruiker.
 */
function portfolio_register_old($gebruikersnaam, $wachtwoord, $mail, $voornaam, $achternaam, $type = "student")
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT gebruikersId FROM " . TABLE_USER . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $gebruikersnaam) . "' OR eMail='" . mysqli_real_escape_string($link, $mail) . "'";
        $result = mysqli_query($link, $sql);
        if(mysqli_fetch_assoc($result))
        {
            echo "<p>Deze gebruikersnaam of e-mail is al in gebruik!</p>";
            return false;
        }
        $sql = "INSERT INTO " . TABLE_USER . "(gebruikersId, voornaam, achternaam, eMail, gebruikersnaam, wachtwoord, rol)"
                . "  VALUES(NULL, "
                 . "'" . mysqli_real_escape_string($link, $voornaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $achternaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $mail) . "', "
                 . "'" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                 . "'" . mysqli_real_escape_string($link, password_hash($wachtwoord, PASSWORD_DEFAULT)) . "', "
                 . "'" . mysqli_real_escape_string($link, $type) . "')";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            return mysqli_insert_id($link);
        }
    }
    return false;
}

/*
 * Zoekt een gebruikersId op dat bij een bepaald mail adres hoort
 */
function portfolio_get_user_id_by_mail($email)
{    
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT gebruikersId FROM " . TABLE_USER . " WHERE eMail='" . mysqli_real_escape_string($link, $email) . "'";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                return $array['gebruikersId'];
            }
        }
    }
    return null;
}

/*
 * Reset het wachtwoord van een gebruiker
 * Genereert een wachtwoord, stelt dit in als het wachtwoord van de gebruiker 
 * en stuurt een mail naar de gebruiker met het nieuwe wachtwoord daar in.
 */
function portfolio_reset_pass($userId)
{
    $link = portfolio_connect();
    if($link)
    {
        $userData = portfolio_get_user_details($userId);
        if(count($userData) > 0)
        {
            $newPass = dechex(rand(268435456, 4294967295)) . dechex(rand(268435456, 4294967295)); //Will result in 16 hexadecimal 'digits'
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            $sql = "UPDATE " . TABLE_USER . " SET wachtwoord='" . mysqli_real_escape_string($link, $hashed) . "' WHERE gebruikersId=" . mysqli_real_escape_string($link, $userId);
            if(mysqli_query($link, $sql))
            {
                //success
                //send email!
                mail($userData['eMail'], 'Password reset for portfolio', "Hello " . $userData['voornaam'] . "\r\n\r\nA password reset was requested for your portfolio account.\r\nYour new password is " . $newPass . "\r\n\r\nThe admin team");
                return true;
            }
        }        
    }
    return null;
}
