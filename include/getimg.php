<?php
/*
 * Geeft een afbeelding terug volgens de img tabel
 */
if(!isset($_GET['name']) || !filter_input(INPUT_GET, 'name'))
{
    die;
}

include 'portfolio.php';

$name = filter_input(INPUT_GET, 'name');

$link = portfolio_connect();
if($link)
{
    $sql = "SELECT * FROM img WHERE naam='" . mysqli_real_escape_string($link, $name) . "'";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        if(($data = mysqli_fetch_assoc($result)))
        {
            //We don't know this, assume jpg for now
            //.$imgurl.''.$imgnaam.''.$imgext.
            header('Content-type: image/jpeg');
            readfile($data['url'] . $data['naam'] . $data['ext']);
        }
    }
}
