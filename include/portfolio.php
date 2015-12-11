<?php

/* 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";

//Session start
session_start();
//Code die altijd gerunt wordt

//Functies
function portfolio_test()
{
    
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
 * 
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
                //Nee, je krijgt geen wachtwoord!
                $userDetails['wachtwoord'] = null;
            }
        }
    }
    
    return $userDetails;
}

/*
 * Upload een bestand. $file is de naam van het bestand e.g. $_FILES[$file]
 */
function portfolio_upload_material($file)
{
    if(!isset($_SESSION['user']))
    {
        return false;
    }
    
    return false;
    // Plaats het bestand op de correcte plaats
    
    //
    $link = portfolio_connect();
    if($link)
    {
        $sql = "INSERT INTO " . TABLE_MATERIAL . " VALUES(NULL, " . $_SESSION['user']['gebruikersId'] . ", "
                . ")";
    }
    return false;
}

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

function portfolio_register($gebruikersnaam, $wachtwoord, $mail, $voornaam, $achternaam, $type = "student")
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "INSERT INTO " . TABLE_USER . " VALUES(NULL, "
                 . "'" . mysqli_real_escape_string($link, $voornaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $achternaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $mail) . "', "
                 . "'" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                 . "'" . mysqli_real_escape_string($link, password_hash($wachtwoord, PASSWORD_DEFAULT)) . "', "
                 . "'" . mysqli_real_escape_string($link, $type) . "')";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            echo "Somthing went wrong!\n";
            echo mysqli_errno($link) . "\n";
            echo mysqli_error($link) . "\n";
            //echo $sql . "\n";
        }
    }
}