<?php

/* 
 * Error log code. Gebruik portfolio_set_error om een error vast te leggen.
 * Gebruik portfolio_error om de laatste error weer te geven.
 * 
 * Wordt niet erg veel gebruikt.
 */

define("PORTFOLIO_ERROR_CONNECT", 1);
define("PORTFOLIO_ERROR_UNAUTHORIZED", 2);
define("PORTFOLIO_ERROR_NOT_FOUND", 3);

function portfolio_set_error($type)
{
   $_SESSION['pflasterror']['type'] = $type;
   $_SESSION['pflasterror']['function'] = debug_backtrace()[1]['function'];
}

function portfolio_clear_error()
{
    unset($_SESSION['pflasterror']);
}

function portfolio_error()
{
    if(isset($_SESSION['pflasterror'])){
        echo '<p><b>Error: ';
        switch($_SESSION['pflasterror']['type'])
        {
            case PORTFOLIO_ERROR_CONNECT:
                echo 'could not connect to database';break;
            case PORTFOLIO_ERROR_UNAUTHORIZED:
                echo 'user was unauthorized for an action';break;
            case PORTFOLIO_ERROR_NOT_FOUND:
                echo 'could not find requested thing in database';break;
            default:
                echo 'unknown';break;
        }
        echo "</b> ";
        echo 'in function: <i>' . $_SESSION['pflasterror']['function'] . '</i></p>';
    }else{
        //Don't do anything?
    }
}