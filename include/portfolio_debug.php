<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * 
 *                          Debug meuk
 * 
 */
define("PORTFOLIO_ERROR_CONNECT", 1);
define("PORTFOLIO_ERROR_UNAUTHORIZED", 2);
define("PORTFOLIO_ERROR_NOT_FOUND", 3);

function portfolio_push_error($type)
{
   $_SESSION['pflasterror']['type'] = $type;
   $_SESSION['pflasterror']['function'] = debug_backtrace()[1]['function'];
}

function portfolio_error()
{
    if(isset($_SESSION['pflasterror'])){
        echo 'Error type: ';
        switch($_SESSION['pflasterror']['type'])
        {
            case PORTFOLIO_ERROR_CONNECT:
                echo 'could not connect to database';break;
            case PORTFOLIO_ERROR_UNAUTHORIZED:
                echo 'user was unauthorized for an action';break;
            case PORTFOLIO_ERROR_NOT_FOUND:
                echo 'could not find request in database';break;
            default:
                echo 'unknown';break;
        }
        echo "<br>\n\r";
        echo 'In function: ' . $_SESSION['pflasterror']['function'];
    }else{
        //Don't do anything?
    }
}