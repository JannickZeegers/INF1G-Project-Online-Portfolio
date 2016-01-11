<!--
    Blijf hier maar van af, het gaat snel kapot :-/
-->
    <a id="homelink" href="admin.php">
        <div id="title">
            <h1 class="title_text">Ons-Portfolio</h1>
        </div>
    </a>
    <div id="cssmenu">
        <ul>
            <?php
            if(isset($_SESSION['user']))
            {
                echo '<li><a href="logout.php">Logout</a></li>';
                if($_SESSION['user']['rol'] === 'student')
                {
                    echo '<li><a href="upload.php">Upload</a></li>';
                }
            }
            else
            {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </div>
