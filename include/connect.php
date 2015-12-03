<?php
    $dbName = "";
    $dbConnect = mysqli_connect("127.0.0.1", "root", "password");
    if($dbConnect !== false)
    {
        $db = mysqli_select_db($dbConnect, $dbName);
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
