<?php
include_once "constants.php";
/*
	Include dit voor database connecties. $dbConnect is de connectie.
*/
    $dbConnect = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
    if($dbConnect !== false)
    {
        $db = mysqli_select_db($dbConnect, DATABASE_NAME);
        if($db === false)
        {
            echo "<p>Unable to connect to the database server.</p>";
            echo "<p>" . mysqli_error($dbConnect) . "</p>";
            mysqli_close($dbConnect);
            $dbConnect = null;
        }
    }
    else
    {
        echo "<p>Unable to connect to the database server.</p>";
    }
?>
