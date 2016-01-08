<?php

/* 
 * Bevat code/functies die door het gehele systeem gedeeld worden
 * Gebruik altijd 
 * 
 * include_once "portfolio.php";
 * 
 * bij het aanmaken van een nieuwe PHP pagina voor de backend (login-, admin-, uploadpagina, etc.)
 * 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";

//Session start
session_start();
//Code die altijd gerunt wordt
//DEBUG
/*echo "<p>" . session_id() . "</p>";
if(fileperms(session_save_path()))
{
    echo "<p>Allowed to save: " . session_save_path() . "</p>";
}*/

//Functies
/*
 * Verbindt met de database server. Returnt een mysqli_connect object bij succes of false bij falen.
 * NOOT: Probeer dit niet op te slaan in een sessie, dat werkt niet....
 */
function portfolio_connect()
{
    $dbConnect = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, DATABASE_NAME, MYSQL_PORT);
    if($dbConnect !== false)
    {
        $db = mysqli_select_db($dbConnect, DATABASE_NAME);
        if($db === false)
        {
            echo "<p>Unable to connect to the database server.</p>";
            echo "<p>" . mysqli_error($dbConnect) . "</p>";
            mysqli_close($dbConnect);
            $dbConnect = false;
        }
    }
    else
    {
        echo "<p>Unable to connect to the database server.</p>";
    }
    return $dbConnect;
}

/*
 * Krijg alle materialen van een gebruiker
 */
function portfolio_get_user_materials($userId)
{
    //Do things
    $link = portfolio_connect();
    if($link)
    {
        $returnResult = array();
        $sql = "SELECT * FROM " . TABLE_MATERIAL . " WHERE eigenaarId=" . mysqli_real_escape_string($link, $userId) . "";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) !== null)
        {
            array_push($returnResult, $row);
        }
        return $returnResult;
    }
    return null;
}
/*
 * Haal alle informatie over een materiaal op
 */
function portfolio_get_material($materialId)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_MATERIAL . " WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if(($row = mysqli_fetch_assoc($result)) !== null)
        {
            return $row;
        }
    }
    return null;
}

/*
 * Haal de gebruikersgegevens van een gebruiker op aan de hand van het gebruikersId
 */
function portfolio_get_user_details($gebruikersId)
{
    $userDetails = array();
    
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE gebruikersId='" . $gebruikersId . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                $userDetails = $array;
                //je krijgt geen wachtwoord!
                $userDetails['wachtwoord'] = null;
            }
        }
    }
    
    return $userDetails;
}

/*
 * Upload een bestand voor de huidige gebruiker. $file is de naam van het bestand e.g. $_FILES[$file]
 */
function portfolio_upload_material($userId, $file, $isPublic)
{
    if(!filter_var($userId, FILTER_VALIDATE_INT) || !isset($_FILES[$file]))
    {
        return false;
    }
    // TODO: Filetype blacklist!
    $name = $_FILES[$file]['name'];
    $ext = pathinfo($name)['extension'];
    $newName = time() . '.' . $ext;
    // MOGELIJKE BUG: portfolio.php MOET in dezelfde map staan als PORTFOLIO_UPLOAD_DIR!!!!
    if(move_uploaded_file($_FILES[$file]['tmp_name'], __DIR__ . '/'  . PORTFOLIO_UPLOAD_DIR . "/" . $newName))
    {
        $link = portfolio_connect();
        if($link)
        {
            //materiaal(materiaalId, naam, eigenaarId, bestandsPad, bestandsType, isOpenbaar)
            $sql = "INSERT INTO " . TABLE_MATERIAL . " VALUES(NULL,"
                    . "'" . mysqli_real_escape_string($link, $name) . "', "
                    . $userId . ", "
                    . "'" . mysqli_real_escape_string($link, PORTFOLIO_UPLOAD_DIR . "/" . $newName) . "', "
                    . "'" . mysqli_real_escape_string($link, $_FILES[$file]['type']) . "', "
                    . $isPublic . ")";
            if(mysqli_query($link, $sql))
            {
                return true;
            }
        }
    }
    else 
    {
        echo "<p>ERROR WHEN MOVING FILE</p>";
    }
    //
    
    return false;
}

/*
 * Probeer in te loggen en sla de gebruikersdata op in $_SESSION['user']
 */
function portfolio_login($userName, $userPass)
{
    $userId = null;
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $userName) . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
             if(($array = mysqli_fetch_assoc($result)) != null)
            {
                if(password_verify($userPass, $array['wachtwoord']))
                {
                    $userId = $array['gebruikersId'];
                    $_SESSION['user'] = $array;
                    $_SESSION['user']['wachtwoord'] = null;
                }
            }
        }
    }
    return $userId;
}

/*
 * Registreer een gebruiker.
 */
function portfolio_register($gebruikersnaam, $wachtwoord, $mail, $voornaam, $achternaam, $type = "student")
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
        $sql = "INSERT INTO " . TABLE_USER . " VALUES(NULL, "
                 . "'" . mysqli_real_escape_string($link, $voornaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $achternaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $mail) . "', "
                 . "'" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                 . "'" . mysqli_real_escape_string($link, password_hash($wachtwoord, PASSWORD_DEFAULT)) . "', "
                 . "'" . mysqli_real_escape_string($link, $type) . "')";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            return true;
        }
    }
    return false;
}

/*
 * Beoordeel een materiaal met een cijfer
 * - Mag alleen als ingelogde gebruiker SLB'er is (slb) (of admin)
 * - Mag alleen als cijfer nog niet gegeven is
 * OF
 *   Alleen beoordelaar mag cijfer aanpassen
 * - 1 <= cijfer <= 10
 */

function portfolio_set_note($materialId, $note)
{
    $link = portfolio_connect();
    
    if($link && $_SESSION['user']['rol'] === 'slb' && $note >= 1 && $note <= 10)
    {
        //Check of er al een cijfer is gegeven!
        $sql = 'SELECT * FROM ' . TABLE_GRADE . ' WHERE materiaalId=' . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        $row = null;    //pak $row BUITEN de if statement
        if(($row = mysqli_fetch_assoc($result)) == null)
        {
            $sql = 'INSERT INTO ' . TABLE_GRADE . ' VALUES(' . 
            mysqli_real_escape_string($link, $materialId) . ', ' . 
            mysqli_real_escape_string($link, $_SESSION['user']['gebruikersId']) . ', ' .  
            mysqli_real_escape_string($link, $note) . 
            ')';
            $result = mysqli_query($link, $sql);
            if($result)
            {
                //succes!
                return true;
            }
        }
        else
        {
            //Er is al een cijfer gegeven!
            if($_SESSION['user']['gebruikersId'] === $row['beoordelaarId'])
            {
                $sql = 'UPDATE ' . TABLE_GRADE . ' SET cijfer='
                        . mysqli_real_escape_string($link, $note)
                        . ' WHERE materiaalId='
                        . mysqli_real_escape_string($link, $materialId);
                $result = mysqli_query($link, $sql);
                if($result)
                {
                    //succes!
                    return true;
                }
            }
        }
    }
    return false;
}

/*
 * Geeft info over het cijfer (indien aanwezig) van een materiaal
 */
function portfolio_get_note($materialId)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_GRADE . " WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if(($row = mysqli_fetch_assoc($result)) !== null)
        {
            return $row;
        }
    }
    return null;
}

/*
 * Geeft alle studentinfo terug
 */
function portfolio_get_students()
{
    $link = portfolio_connect();
    if($link)
    {
        $return = array();
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE rol='student'";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) != null)
        {
            array_push($return, $row);
        }
        return $return;
    }
    return null;
}

/*
 * Update gegevens van een materiaal
 */
function portfolio_update_material($materialId, $name=null, $isPublic=null)
{
    $link = portfolio_connect();
    if($link && ($name != null || $isPublic != null))
    {
        $sql = "UPDATE " . TABLE_MATERIAL . " SET ";
        if($name != null)
            $sql .= "naam='" . mysqli_real_escape_string($link, $name) . "' ";
        if($isPublic != null)
            $sql .= "isOpenbaar='" . mysqli_real_escape_string($link, $isPublic) . "' ";
        $sql .= "WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if($result)
            return true;
    }
    return null;
}

/*
 * Verwijder een materiaal, zolang het niet beoordeeld is
 */
function portfolio_delete_material($materialId, $forceDeletion=false)
{
    $link = portfolio_connect();
    if($link)
    {
        if(!portfolio_get_note($materialId) || $forceDeletion)
        {
            $sql = "DELETE FROM " . TABLE_MATERIAL . " WHERE materiaalIc=" . $materialId;
            $result = mysqli_query($link, $sql);
            if($result)
                return true;
        }
    }
    return null;
}