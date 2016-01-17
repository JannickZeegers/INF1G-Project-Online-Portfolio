<?php
header("Access-Control-Allow-Origin: *");
include 'portfolio.php';

$action = filter_input(INPUT_POST, 'action');
//$params = filter_input(INPUT_POST, 'params');
//$action = filter_input(INPUT_GET, 'action');

switch($action)
{
    case 'get':{
        $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
        if($userId){
            $link = portfolio_connect();
            if($link){
                $sql = "SELECT * FROM " . TABLE_GUESTBOOK . " WHERE ontvangerID=" . mysqli_real_escape_string($link, $userId) . " ORDER BY berichtID DESC";
                $result = mysqli_query($link, $sql);
                if($result){
                    $messageArray = array();
                    while(($row = mysqli_fetch_assoc($result))){
                        $row['bericht'] = htmlentities($row['bericht']);
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
                        $sql = "INSERT INTO " . TABLE_GUESTBOOK . " (berichtID, zendernaam, email, bericht, ontvangerID) VALUES(NULL, '"
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
    default:{
        echo json_encode('default');
        break;
    }
}
