<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include "../portfolio.php";
        // put your code here
        if(isset($_POST["submit"]))
        {
            echo "<pre>";
            //FIX: SESSION NIET CONSISTENT OP SERVER
            var_dump($_SESSION['user']);
            //DEBUG: UPLOAD ALTIJD VOOR USER ID 7
            var_dump(portfolio_upload_material(7, 'file'));
            echo "</pre>";
        }
        ?>
        <h1>Upload file</h1>
        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' enctype="multipart/form-data">
            <p>File<br><input type="file" name="file"></p>
            <p><input type='submit' name='submit' value='upload'></p>
        </form>
    </body>
</html>
