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
                echo '<li><a href="admin.php">Home</a></li>';
                if($_SESSION['user']['rol'] === 'student')
                {
                    echo '<li><a href="upload.php">Upload</a></li>';
                    echo '<li><a href="viewnotes.php?student=' . $_SESSION['user']['gebruikersId'] . '">Mijn cijfers</a></li>';
                }
                if($_SESSION['user']['rol'] === 'docent' || $_SESSION['user']['rol'] === 'slb')
                {
                    //Naar overzicht studenten
                    echo '<li><a href="students.php">Studenten</a></li>';
                }
                if($_SESSION['user']['rol'] === 'admin')
                {
                    //Naar overzicht gebruikers
                    echo '<li><a href="users.php">Gebruikers</a></li>';
                    //Naar overzicht vakken
                    echo '<li><a href="subjects.php">Vakken</a></li>';
                }
                //Mail
                //Andere mail pagina's bereikbaar via inbox om menu niet te vol te krijgen?
                echo '<li><a href="mailinbox.php">Mail</a></li>';
                //Als laatste
                echo '<li><a href="logout.php">Logout</a></li>';
            }
            else
            {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </div>
