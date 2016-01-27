<?php
header("Access-Control-Allow-Origin: *");   //Needed because we will be accessing this from another (sub)domain
include 'portfolio.php';                    //Required for database connection and table name constants

$action = filter_input(INPUT_POST, 'action');
/*
 * This is a php page that handles guestbook interaction via post requests.
 * Returns json encoded stuff.
 */
switch($action)
{
    case 'get':{
        $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
        if($userId){
            $link = portfolio_connect();
            if($link){
                $sql = "SELECT * FROM " . TABLE_GUESTBOOK . " WHERE ontvangerId=" . mysqli_real_escape_string($link, $userId) . " ORDER BY berichtId DESC";
                $result = mysqli_query($link, $sql);
                if($result){
                    $messageArray = array();
                    while(($row = mysqli_fetch_assoc($result))){
                        $row['bericht'] = $row['bericht'];
                        array_push($messageArray, $row);
                    }
                    echo json_encode($messageArray);
                    break;
                }
            }
        }
        echo json_encode('error');
        break;
    }
    case 'add':{
        $name = filter_input(INPUT_POST, 'name');
        $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
        $msg = filter_input(INPUT_POST, 'message');
        $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
        if(!empty($userId) && !empty($name) && !empty($mail) && !empty($msg)){
            if($mail){
                if(strlen($name) <= 60 && strlen($msg) <= 700){
                    $link = portfolio_connect();
                    if($link){
                        $sql = "INSERT INTO " . TABLE_GUESTBOOK . " (berichtId, zendernaam, email, bericht, ontvangerId) VALUES(NULL, '"
                                . mysqli_real_escape_string($link, $name) . "', '"
                                . mysqli_real_escape_string($link, $mail) . "', '"
                                . mysqli_real_escape_string($link, $msg) . "', "
                                . mysqli_real_escape_string($link, $userId) . ")";
                        $result = mysqli_query($link, $sql);
                        if($result){
                            echo json_encode('success');
                        }
                    }
                }
                else{
                    if(strlen($name) > 35){
                        echo json_encode(array('error' => 'name'));
                    }else{
                        echo json_encode(array('error' => 'message'));
                    }
                }
            }
            else{
                echo json_encode(array('error' => 'mail'));
            }
        }
        break;
    }
    /*
     * Untested!
     */
    case 'delete':{
        $messageId = filter_input(INPUT_POST, 'messageId', FILTER_VALIDATE_INT);
        if($messageId){
            $link = portfolio_connect();
            if($link){
                $sql = "DELETE FROM " . TABLE_GUESTBOOK . " WHERE berichtId=" . mysqli_real_escape_string($link, $messageId);
                $result = mysqli_query($link, $sql);
                if($result){
                    echo json_encode('success');
                    break;
                }
            }
        }
        echo json_encode('error');
        break;
    }
    default:{
        echo json_encode('unknown');
        break;
    }
}
