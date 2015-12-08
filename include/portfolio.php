<?php

/* 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";

//Session start
session_start();
//Code die altijd gerunt wordt
if(!isset($_SESSION["dbLink"]))
{
    $dbLink = portfolio_connect();
    if($dbLink)
    {
        $_SESSION["dbLink"] = $dbLink;
    }
}

//Functies
function portfolio_test()
{
    
}

/*
 * Verbindt met de database server. Returnt een mysqli_connect object bij succes of false bij falen.
 */
function portfolio_connect()
{
    $dbConnect = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
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

function portfolio_disconnect()
{
    if(isset($_SESSION["dbLink"]))
    {
        mysqli_close($_SESSION["dbLink"]);
    }
}

/*
 * Returns a mysqli result object with all materials that are owned by that user
 */
function portfolio_get_user_materials($userId)
{
    //Do things
    
    return null;
}

/*function portfolio_dev_create_database()
{
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
    if($link)
    {
        $sql = "CREATE DATABASE " . DATABASE_NAME;
        if(mysqli_query($link, $sql))
        {
            $sql = "CREATE TABLE " . TABLE_USERS . "(";
        }
    }
}*/

function portfolio_get_user_details($gebruikersId)
{
    $userDetails = array();
    
    $link = (isset($_SESSION["dbLink"])) ? $_SESSION["dbLink"] : null;
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USERS . " WHERE gebruikersId='" . $gebruikersId . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                $userDetails = $array;
                //Nope nope nope nope nope
                $userDetails['wachtwoord'] = null;
            }
        }
    }
    
    return $userDetails;
}

function portfolio_login($userName, $userPass)
{
    $userId = null;
    $link = (isset($_SESSION["dbLink"])) ? $_SESSION["dbLink"] : null;
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USERS . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $userName) . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
             if(($array = mysqli_fetch_assoc($result)) != null)
            {
                if(password_verify($userPass, $array['wachtwoord']))
                {
                    $userId = $array['gebruikersId'];
                }
            }
        }
    }
    return $userId;
}

function portfolio_register($userName, $userPass, $userMail, $voornaam = "henk", $achternaam = "henk", $type = "student")
{
    $link = (isset($_SESSION["dbLink"])) ? $_SESSION["dbLink"] : null;
    if($link)
    {
        $sql = "INSERT INTO " . TABLE_USERS . " VALUES(NULL, "
                 . "'" . mysqli_real_escape_string($link, $voornaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $achternaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $userMail) . "', "
                 . "'" . mysqli_real_escape_string($link, $userName) . "', "
                 . "'" . mysqli_real_escape_string($link, password_hash($userPass, PASSWORD_DEFAULT)) . "', "
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