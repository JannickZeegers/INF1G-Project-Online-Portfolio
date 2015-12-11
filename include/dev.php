<?php
include_once 'portfolio.php';
/* 
 * Bevat code voor bij het maken van het systeem, zoals een functie om de database mee op te zetten.
 */

/*
 * Maakt de database aan met correcte tabellen.
 * !!! Zorg ervoor dat je EERST een user aanmaakt op je database ding met de naam en wachtwoord die in constants.php staan! !!!
 */
/*
function portfolio_dev_create_database($database_name)
{
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, DATABASE_NAME, MYSQL_PORT);
    mysqli_connect_error();
    if($link)
    {
        //$sql = "CREATE DATABASE " . $database_name;
        //if(mysqli_query($link, $sql))
        {
            mysqli_select_db($link, $database_name);
            
            $sql = "
CREATE TABLE " . TABLE_USER . " (
  `gebruikersId` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(12) NOT NULL,
  `achternaam` varchar(20) NOT NULL,
  `e-mail` varchar(40) NOT NULL,
  `gebruikersnaam` varchar(16) NOT NULL,
  `wachtwoord` char(255) NOT NULL,
  `type` enum('student','docent','slb','admin') NOT NULL DEFAULT 'student',
  PRIMARY KEY (`gebruikersId`),
  UNIQUE KEY `USERNAME` (`gebruikersnaam`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
            $sql = "
CREATE TABLE " . TABLE_MATERIAL . " (
  `materiaalId` int(11) NOT NULL AUTO_INCREMENT,
  `eigenaarId` int(11) NOT NULL,
  `bestandsPad` varchar(255) NOT NULL,
  `bestandsType` varchar(8) NOT NULL,
  PRIMARY KEY (`materiaalId`),
  KEY `eigenaarId` (`eigenaarId`),
  CONSTRAINT `FK_eigenaar` FOREIGN KEY (`eigenaarId`) REFERENCES `gebruiker` (`gebruikersId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
            $sql = "
CREATE TABLE " . TABLE_SUBJECT . " (
  `vakId` int(11) NOT NULL AUTO_INCREMENT,
  `vaknaam` varchar(45) NOT NULL,
  PRIMARY KEY (`vakId`),
  UNIQUE KEY `VAKNAAM_UNIEK` (`vaknaam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
            $sql = "CREATE TABLE " . TABLE_MATERIAL_SUBJECT . " (
  `materiaalId` int(11) NOT NULL,
  `vakId` int(11) NOT NULL,
  PRIMARY KEY (`materiaalId`,`vakId`),
  KEY `FK_vak` (`vakId`),
  CONSTRAINT `FK_materiaal` FOREIGN KEY (`materiaalId`) REFERENCES `materiaal` (`materiaalId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vak` FOREIGN KEY (`vakId`) REFERENCES `vak` (`vakId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
            $sql = "
CREATE TABLE " . TABLE_GRADE . " (
  `materiaalId` int(11) NOT NULL,
  `beoordelaarId` int(11) NOT NULL,
  `cijfer` decimal(2,1) NOT NULL,
  PRIMARY KEY (`beoordelaarId`,`materiaalId`),
  KEY `FK_c_materiaal` (`materiaalId`),
  CONSTRAINT `FK_beoordelaar` FOREIGN KEY (`beoordelaarId`) REFERENCES `gebruiker` (`gebruikersId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_c_materiaal` FOREIGN KEY (`materiaalId`) REFERENCES `materiaal` (`materiaalId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
            $sql = "CREATE TABLE " . TABLE_GUESTBOOK . " (
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `eigenaarId` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `eigenaarId` (`eigenaarId`),
  CONSTRAINT `eigenaar_res` FOREIGN KEY (`eigenaarId`) REFERENCES `gebruiker` (`gebruikersId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
            mysqli_query($link, $sql);
        }
        echo "Error data:<br>\n";
        echo mysqli_errno($link) . "<br>\n";
        echo mysqli_error($link) . "<br>\n";
    }
}
*/
/*
 * Come with me if you want to live
 */
/*
function portfolio_dev_terminate_database($database_name)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "DROP DATABASE " . $database_name;
        if(mysqli_query($link, $sql))
        {
            echo "Database terminated!<br>\n";
            return;
        }
    }
    echo "Something went wrong.<br>\n";
}*/