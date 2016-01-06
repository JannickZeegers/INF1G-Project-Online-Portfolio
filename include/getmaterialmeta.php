<?php
/*
 * Geeft informatie over een materiaal terug, zolang MATERIAAL.isOpenbaar op true staat
 * POST: material=id-van-materiaal
 * RESULTAAT: 'textbestand' met de volgende opbouw
 * 
materiaalId (int)
naam (string)
eigenaarId (int)
bestandsPad (string)
bestandsType (string, MIME)
isOpenbaar (bool/int)
(lege regel)
 * 
 * BIJVOORBEELD:
1
snapshot.png
1
files/1452088788.png
image/png
1

 * 
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
//NOT AN IMAGE
header('Content-Type: text/plain');
//NOTE: Zorg zelf voor http://ons-portfolio.nl/
foreach($matData as $value)
{
    echo $value . "\n";
}