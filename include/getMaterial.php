<?php
/*
 * Geeft een materiaal terug.
 * POST: material=id-van-materiaal&user=id-van-eigenaar
 */
if(!isset($_POST['material']) || filter_input(INPUT_POST, 'material', FILTER_VALIDATE_INT) || 
        !isset($_POST['user']) || filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT))
{
    die;
}

include 'portfolio.php';

$matId = filter_input(INPUT_POST, 'material', FILTER_VALIDATE_INT);
$usrId = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);

$matData = portfolio_get_material($matId);
if(!$matData || $matData['eigenaarId'] !== $usrId)
{
    die;
}
$imgMime = array('image/png');
if(in_array($matData['bestandsType'], $imgMime))
{
    //IMAGE
    header('Content-type: ' . $matData['bestandsType']);
    //bugs bugs bugs?
    readfile($matData['bestandsPad']);
}
else
{
    //NOT AN IMAGE
    header('Content-Type: text/plain');
    //NOTE: Zorg zelf voor http://ons-portfolio.nl/
    echo $matData['bestandsPad'];
}