<?php

/* 
 * Bevat code/functies die door het gehele systeem gedeeld worden
 * Gebruik altijd 
 * 
 * include_once "portfolio.php";
 * 
 * bij het aanmaken van een nieuwe PHP pagina voor de backend (login-, admin-, uploadpagina, etc.)
 * 
 * Functies in dit bestand beginnen met portfolio_
 */
//Includes
include_once "constants.php";

//Session start
session_start();
//Code die altijd gerunt wordt
//DEBUG
/*echo "<p>" . session_id() . "</p>";
if(fileperms(session_save_path()))
{
    echo "<p>Allowed to save: " . session_save_path() . "</p>";
}*/

//Functies
/*
 * Verbindt met de database server. Returnt een mysqli_connect object bij succes of false bij falen.
 * NOOT: Probeer dit niet op te slaan in een sessie, dat werkt niet....
 */
function portfolio_connect()
{
    $dbConnect = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, DATABASE_NAME, MYSQL_PORT);
    if($dbConnect !== false)
    {
        $db = mysqli_select_db($dbConnect, DATABASE_NAME);
        if($db === false)
        {
            echo "<p>Unable to connect to the database server.</p>";
            echo "<p>" . mysqli_error($dbConnect) . "</p>";
            mysqli_close($dbConnect);
            $dbConnect = false;
        }
    }
    else
    {
        echo "<p>Unable to connect to the database server.</p>";
    }
    return $dbConnect;
}

/*
 * Krijg alle materialen van een gebruiker
 */
function portfolio_get_user_materials($userId)
{
    //Do things
    $link = portfolio_connect();
    if($link)
    {
        $returnResult = array();
        $sql = "SELECT * FROM " . TABLE_MATERIAL . " WHERE eigenaarId=" . mysqli_real_escape_string($link, $userId) . "";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) !== null)
        {
            array_push($returnResult, $row);
        }
        return $returnResult;
    }
    return null;
}
/*
 * Haal alle informatie over een materiaal op
 */
function portfolio_get_material($materialId)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_MATERIAL . " WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if(($row = mysqli_fetch_assoc($result)) !== null)
        {
            return $row;
        }
    }
    return null;
}

/*
 * Haal de gebruikersgegevens van een gebruiker op aan de hand van het gebruikersId
 */
function portfolio_get_user_details($gebruikersId)
{
    $userDetails = array();
    
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE gebruikersId='" . $gebruikersId . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
            if(($array = mysqli_fetch_assoc($result)) != null)
            {
                $userDetails = $array;
                //je krijgt geen wachtwoord!
                $userDetails['wachtwoord'] = null;
            }
        }
    }
    
    return $userDetails;
}

/*
 * Upload een bestand voor de huidige gebruiker. $file is de naam van het bestand e.g. $_FILES[$file]
 */
function portfolio_upload_material($userId, $file, $isPublic)
{
    if(!filter_var($userId, FILTER_VALIDATE_INT) || !isset($_FILES[$file]))
    {
        return false;
    }
    // TODO: Filetype blacklist!
    $blacklist = array('application/octet-stream', 'application/x-bsh', 'application/x-sh', 'application/x-shar', 'text/x-script.sh', 'text/html', 'text/x-server-parsed-html');
    if(in_array($_FILES[$file]['type'], $blacklist))
    {
        echo '<p>FILE TYPE NOT ALLOWED</p>';
        return false;
    }
    $name = $_FILES[$file]['name'];
    $ext = pathinfo($name)['extension'];
    $newName = time() . '.' . $ext;
    // MOGELIJKE BUG: portfolio.php MOET in dezelfde map staan als PORTFOLIO_UPLOAD_DIR!!!!
    if(move_uploaded_file($_FILES[$file]['tmp_name'], __DIR__ . '/'  . PORTFOLIO_UPLOAD_DIR . "/" . $newName))
    {
        $link = portfolio_connect();
        if($link)
        {
            //materiaal(materiaalId, naam, eigenaarId, bestandsPad, bestandsType, isOpenbaar)
            $sql = "INSERT INTO " . TABLE_MATERIAL . " VALUES(NULL,"
                    . "'" . mysqli_real_escape_string($link, $name) . "', "
                    . $userId . ", "
                    . "'" . mysqli_real_escape_string($link, PORTFOLIO_UPLOAD_DIR . "/" . $newName) . "', "
                    . "'" . mysqli_real_escape_string($link, $_FILES[$file]['type']) . "', "
                    . $isPublic . ")";
            if(mysqli_query($link, $sql))
            {
                return true;
            }
        }
    }
    else 
    {
        echo "<p>ERROR WHEN MOVING FILE</p>";
    }
    //
    
    return false;
}

/*
 * Probeer in te loggen en sla de gebruikersdata op in $_SESSION['user']
 */
function portfolio_login($userName, $userPass)
{
    $userId = null;
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $userName) . "'";
        $result = mysqli_query($link, $sql);
        if($result !== false)
        {
             if(($array = mysqli_fetch_assoc($result)) != null)
            {
                if(password_verify($userPass, $array['wachtwoord']))
                {
                    $userId = $array['gebruikersId'];
                    $_SESSION['user'] = $array;
                    $_SESSION['user']['wachtwoord'] = null;
                }
            }
        }
    }
    return $userId;
}

function portfolio_logout()
{
    if(isset($_SESSION['user']))
    {
        unset($_SESSION['user']);
    }
    return session_destroy();
}

/*
 * Registreer een gebruiker.
 */
function portfolio_register($gebruikersnaam, $wachtwoord, $mail, $voornaam, $achternaam, $type = "student")
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT gebruikersId FROM " . TABLE_USER . " WHERE gebruikersnaam='" . mysqli_real_escape_string($link, $gebruikersnaam) . "' OR eMail='" . mysqli_real_escape_string($link, $mail) . "'";
        $result = mysqli_query($link, $sql);
        if(mysqli_fetch_assoc($result))
        {
            echo "<p>Deze gebruikersnaam of e-mail is al in gebruik!</p>";
            return false;
        }
        $sql = "INSERT INTO " . TABLE_USER . " VALUES(NULL, "
                 . "'" . mysqli_real_escape_string($link, $voornaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $achternaam) . "', "
                 . "'" . mysqli_real_escape_string($link, $mail) . "', "
                 . "'" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                 . "'" . mysqli_real_escape_string($link, password_hash($wachtwoord, PASSWORD_DEFAULT)) . "', "
                 . "'" . mysqli_real_escape_string($link, $type) . "')";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            return mysqli_insert_id($link);
        }
    }
    return false;
}

/*
 * Beoordeel een materiaal met een cijfer
 * - Mag alleen als ingelogde gebruiker SLB'er is (slb) (of admin)
 * - Mag alleen als cijfer nog niet gegeven is
 * OF
 *   Alleen beoordelaar mag cijfer aanpassen
 * - 1 <= cijfer <= 10
 */

function portfolio_set_note($materialId, $note)
{
    $link = portfolio_connect();
    
    if($link && portfolio_user_is_of_type(array('slb', 'admin')) && $note >= 1 && $note <= 10)
    {
        //Check of er al een cijfer is gegeven!
        $sql = 'SELECT * FROM ' . TABLE_GRADE . ' WHERE materiaalId=' . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        $row = null;    //pak $row BUITEN de if statement
        if(($row = mysqli_fetch_assoc($result)) == null)
        {
            $sql = 'INSERT INTO ' . TABLE_GRADE . ' VALUES(' . 
            mysqli_real_escape_string($link, $materialId) . ', ' . 
            mysqli_real_escape_string($link, $_SESSION['user']['gebruikersId']) . ', ' .  
            mysqli_real_escape_string($link, $note) . 
            ')';
            $result = mysqli_query($link, $sql);
            if($result)
            {
                //succes!
                return true;
            }
        }
        else
        {
            //Er is al een cijfer gegeven!
            if($_SESSION['user']['gebruikersId'] === $row['beoordelaarId'] || portfolio_user_is_of_type(array('admin')))
            {
                $sql = 'UPDATE ' . TABLE_GRADE . ' SET cijfer='
                        . mysqli_real_escape_string($link, $note)
                        . ' , beoordelaarId='
                        . mysqli_real_escape_string($link, $_SESSION['user']['gebruikersId'])
                        . ' WHERE materiaalId='
                        . mysqli_real_escape_string($link, $materialId);
                $result = mysqli_query($link, $sql);
                if($result)
                {
                    //succes!
                    return true;
                }
            }
        }
    }
    return false;
}

/*
 * Geeft info over het cijfer (indien aanwezig) van een materiaal
 */
function portfolio_get_note($materialId)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "SELECT * FROM " . TABLE_GRADE . " WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if(($row = mysqli_fetch_assoc($result)) !== null)
        {
            return $row;
        }
    }
    return null;
}

/*
 * Geeft alle studentinfo terug
 */
function portfolio_get_students()
{
    $link = portfolio_connect();
    if($link)
    {
        $return = array();
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE rol='student'";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) != null)
        {
            array_push($return, $row);
        }
        return $return;
    }
    return null;
}

/*
 * Geeft alle studentinfo terug
 */
function portfolio_get_users()
{
    $link = portfolio_connect();
    if($link)
    {
        $return = array();
        $sql = "SELECT * FROM " . TABLE_USER . " ORDER BY rol ASC";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) != null)
        {
            array_push($return, $row);
        }
        return $return;
    }
    return null;
}

/*
 * Geeft de berichten voor de gebruiker terug
 */
function portfolio_get_messages($userId)
{
    $link = portfolio_connect();
    if($link)
    {
        $return = array();
        //$userId = $_SESSION['user']['gebruikersId'];
        $sql = "SELECT * FROM " . TABLE_MESSAGE . " WHERE ontvangerID = '$userId' ORDER BY berichtId ASC";
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) != null)
        {
            array_push($return, $row);
        }
        return $return;
    }
    return null;
}

/*
 * Update gegevens van een materiaal
 */
function portfolio_update_material($materialId, $name=null, $isPublic=null)
{
    $link = portfolio_connect();
    if($link && ($name != null || $isPublic != null))
    {
        $sql = "UPDATE " . TABLE_MATERIAL . " SET ";
        if($name != null)
            $sql .= "naam='" . mysqli_real_escape_string($link, $name) . "' ";
        if($isPublic != null)
            $sql .= "isOpenbaar='" . mysqli_real_escape_string($link, $isPublic) . "' ";
        $sql .= "WHERE materiaalId=" . mysqli_real_escape_string($link, $materialId);
        $result = mysqli_query($link, $sql);
        if($result)
            return true;
    }
    return null;
}

/*
 * Verwijder een materiaal, zolang het niet beoordeeld is
 */
function portfolio_delete_material($materialId, $forceDeletion=false)
{
    $link = portfolio_connect();
    if($link)
    {
        if(!portfolio_get_note($materialId) || $forceDeletion)
        {
            $matData = portfolio_get_material($materialId);
            if($matData)
            {
                $sql = "DELETE FROM " . TABLE_MATERIAL . " WHERE materiaalId=" . $materialId;
                $result = mysqli_query($link, $sql);
                if($result)
                {
                    //var_dump(__DIR__ . '/' . $matData['bestandsPad']);
                    unlink(__DIR__ . '/' . $matData['bestandsPad']);
                }
                return $result;
            }
        }
    }
    return null;
}

/*
 * Verwijder een gebruiker
 */
function portfolio_delete_user($userId)
{
    $link = portfolio_connect();
    if($link)
    {
        if(!portfolio_user_is_of_type(array('admin')))
        {
            return null;
        }
        $userData = portfolio_get_user_details($userId);
        if($userData['gebruikersId'] === $_SESSION['user']['gebruikersId'])
        {
            return null;
        }
        $matData = portfolio_get_user_materials($userId);
        foreach($matData as $m)
        {
            //Verwijder het cijfer!
            if(portfolio_get_note($m['materiaalId']))
            {
                $sql = "DELETE FROM " . TABLE_GRADE . " WHERE materiaalId=" . mysqli_real_escape_string($link, $m['materiaalId']);
                if(!mysqli_query($link, $sql))
                {
                    return false;
                }
            }
            //Verwijder het materiaal
            if(!portfolio_delete_material($m['materiaalId']))
            {
                return false;
            }
        }
        //Gegeven cijfers
        if($userData['rol'] !== 'student')
        {
            $sql = "UPDATE " . TABLE_GRADE . " SET beoordelaarId=NULL WHERE beoordelaarId=" . mysqli_real_escape_string($link, $userData['gebruikersId']);
            if(!mysqli_query($link, $sql))
            {
                return false;
            }
        }
        //Verwijder de gebruiker
        $sql = "DELETE FROM " . TABLE_USER . " WHERE gebruikersId=" . mysqli_real_escape_string($link, $userId);
        if(mysqli_query($link, $sql))
        {
            return true;
        }
    }
    return null;
}

/*
 * Check of de ingelogde gebruiker een van deze rollen heeft
 */
function portfolio_user_is_of_type($types = array('student', 'slb', 'admin', 'docent'))
{
    if(isset($_SESSION['user']))
    {
        return in_array($_SESSION['user']['rol'], $types);
    }
    return false;
}

/*
 * Wijzig gebruiker
 * - Alleen voor ingelogde admin
 * - NULL parameters worden niet geupdate!
 */
function portfolio_update_user($userId, $voornaam = null, $achternaam = null, $gebruikersnaam = null, $email = null, $rol = null)
{
    if(!portfolio_user_is_of_type(array('admin')))
    {
        return null;
    }
    
    $link = portfolio_connect();
    if($link)
    {
        $userData = portfolio_get_user_details($userId);
        if($userData)
        {
            $voornaam = ($voornaam) ? $voornaam : $userData['voornaam'];
            $achternaam = ($achternaam) ? $achternaam : $userData['achternaam'];
            $gebruikersnaam = ($gebruikersnaam) ? $gebruikersnaam : $userData['gebruikersnaam'];
            $email = ($email) ? $email : $userData['eMail'];
            //$wachtwoord = ($wachtwoord) ? $wachtwoord : $userData['wachtwoord'];
            $rol = ($rol) ? $rol : $userData['rol'];
            $sql = "UPDATE " . TABLE_USER . " SET "
                    . "voornaam='" . mysqli_real_escape_string($link, $voornaam) . "', "
                    . "achternaam='" . mysqli_real_escape_string($link, $achternaam) . "', "
                    . "gebruikersnaam='" . mysqli_real_escape_string($link, $gebruikersnaam) . "', "
                    . "eMail='" . mysqli_real_escape_string($link, $email) . "', "
                    . "rol='" . mysqli_real_escape_string($link, $rol)
                    . "' WHERE gebruikersId=" . mysqli_real_escape_string($link, $userId);
            $result = mysqli_query($link, $sql);
            return $result;
        }
    }
    
    return null;
}

/*
 * Maak nieuw vak aan
 * Returnt het vakId van het aangemaakte vak
 */
function portfolio_add_subject($name)
{
    $link = portfolio_connect();
    if($link)
    {
        $sql = "INSERT INTO " . TABLE_SUBJECT . " VALUES (NULL, '" . mysqli_real_escape_string($link, $name) . "')";
        if(mysqli_query($link, $sql))
        {
            return mysqli_insert_id($link);
        }
    }
    return false;
}

function portfolio_get_subjects()
{
    $link = portfolio_connect();
    if($link)
    {
        $return = array();
        $sql = "SELECT * FROM " . TABLE_SUBJECT;
        $result = mysqli_query($link, $sql);
        while(($row = mysqli_fetch_assoc($result)) != null)
        {
            array_push($return, $row);
        }
        return $return;
    }
    return null;
}

/*
 * Geeft alle cijfers van een student terug
 */
function portfolio_get_student_notes($userId)
{
    $link = portfolio_connect();
    if($link)
    {
        $mats = portfolio_get_user_materials($userId);
        if(count($mats) > 0)
        {
            $result = array();
            foreach($mats as $m)
            {
                $c = portfolio_get_note($m['materiaalId']);
                if($c)
                {
                    array_push($result, $c);
                }
            }
            return $result;
        }
    }
    return null;
}

function registreer($voornaam, $achternaam, $mail, $pass, $gebrnaam, $rol) 	
{  
	$DataBaseConnect = new mysqli("mysql765.cp.hostnet.nl", "u219753_pfs", "{ix38ZA(XF8tRK|o", "db219753_portfolio_systeem");
	$hash = crypt($pass);
	
	$stmt = $DataBaseConnect->prepare("INSERT INTO gebruiker (voornaam, achternaam, eMail, gebruikersnaam, wachtwoord, rol)
									   VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $voornaam, $achternaam, $mail, $hash, $gebrnaam, $rol);
	$invoer = $stmt->execute();                                                                                                     
	
	if ($invoer === FALSE) 
	{ 
		echo "<p>De opdracht kan niet worden uitgevoerd.</p>" . "<p class='error'>Error code " . mysqli_errno($DataBaseConnect) . ": " . mysqli_error($DataBaseConnect) . "</p>";       
	} 
	$stmt->close();
	$DataBaseConnect->close();
}

/*
 * Is 
 */
function resetpass($userID, $oudpass, $nieuwpass) 
{
	$DataBaseConnect = new mysqli("mysql765.cp.hostnet.nl", "u219753_pfs", "{ix38ZA(XF8tRK|o", "db219753_portfolio_systeem");
	
        //Misschien niet handig als je een wachtwoord wil resetten als je het oude niet meer weet :P
	if (password_verify($oudpass, $hash)) 
	{
            //wat?
		//$newhash = crypt($pass); 
                $newhash = password_hash($nieuwpass, PASSWORD_DEFAULT);
		$stmt = $DataBaseConnect->prepare("UPDATE userId gebruiker 
										   SET wachtwoord=?
										   WHERE userID=?");
		$stmt->bind_param("si", $newhash, $userID);
		$invoer = $stmt->execute(); 
		
                //Tip:
                //($var !== false) ---> ($var), zelfde resultaat, meestal beter
		if ($invoer) {
			echo "<p>Your password-values have been succesfully changed</p>";
		} else {
			echo "<p>Password does not match</p>"; 
			}
	}
	$stmt->close();
	$DataBaseConnect->close();
}


