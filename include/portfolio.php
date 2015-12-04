<?php

/* 
 * De include voor het front end om het systeem te kunnen gebruiken.
 * Bevat onder andere functies voor interactie met het portfolio systeem.
 * 
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

function portfolio_dev_create_database()
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
}