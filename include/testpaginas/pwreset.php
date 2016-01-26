<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../portfolio.php';
if(portfolio_user_is_of_type(array('admin', 'student', 'slb', 'docent')))
{
    if(portfolio_reset_pass($_SESSION['user']['gebruikersId']))
    {
        echo 'PW WAS RESET';
    }
}