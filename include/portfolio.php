<?php

/* 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";
//FIX FOR THINGS
ini_set('session.cookie_domain', '.DOMAIN.EXT');
//phpinfo();
if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
}
//Session start
session_start();
//Code die altijd gerunt wordt
//DEBUG
echo "<p>" . session_id() . "</p>";
//Functies
function portfolio_test()
{
    return true;
}
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
function portfolio_upload_material($userId, $file)
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
            $sql = "INSERT INTO " . TABLE_MATERIAL . " VALUES(NULL, " . $userId . ", "
                    . "'" . mysqli_real_escape_string($link, PORTFOLIO_UPLOAD_DIR . "/" . $newName) . "', "
                    . "'" . mysqli_real_escape_string($link, $_FILES[$file]['type']) . "')";
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
        $sql = "SELECT gebruikersId FROM " . TABLE_USER . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $gebruikersnaam) . "' OR `e-mail`='" . mysqli_real_escape_string($link, $mail) . "'";
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