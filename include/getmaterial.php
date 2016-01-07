<?php
/*
 * Geeft een materiaal terug, zolang MATERIAAL.isOpenbaar op true staat
 * POST: material=id-van-materiaal
 * RESULTAAT: 
 * afbeelding (als het MIME type een afbeelding is)
 * OF
 * 'textdocument' met de bestandslocatie (files/bestandsnaam.extensie)
 */
if(!isset($_GET['material']) || !filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT))
{
    die;
}

include 'portfolio.php';

$matId = filter_input(INPUT_GET, 'material', FILTER_VALIDATE_INT);

$matData = portfolio_get_material($matId);
//var_dump($matData);
//Note: returns all as string!
if(!$matData || $matData['isOpenbaar'] == false)
{
    die;
}
$imgMime = array("image/jpeg","image/pjpeg","image/gif","image/bmp","image/x-windows-bmp","image/png");
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
