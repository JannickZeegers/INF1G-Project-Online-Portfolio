<?php

/* 
 * Constantes
 * ZET PORTFOLIO_DATABASE_MODE OP PORTFOLIO_MODE_SERVER VOOR UPLOAD NAAR SERVER!
 * 
 * NOOT: Voor PORTFOLIO_MODE_LOCAL is het nodig om een database te hebben op de localhost.
 * Zie de dropbox - Project -/SQL map voor de benodigde SQL scripts om dit op te zetten.
 */
//0 = lokaal, 1 = op server, php 'thuis', 2 = op server
define("PORTFOLIO_MODE_LOCAL", 0);
define("PORTFOLIO_MODE_SERVER_REMOTE", 1);
define("PORTFOLIO_MODE_SERVER", 2);

define("PORTFOLIO_DATABASE_MODE", PORTFOLIO_MODE_SERVER_REMOTE);
if(PORTFOLIO_DATABASE_MODE === PORTFOLIO_MODE_LOCAL)
{
    define("DATABASE_NAME", "portfolio_systeem");
    define("MYSQL_HOST", "localhost");
    define("MYSQL_PORT", ini_get("mysqli.default_port"));
    define("MYSQL_USER", "portfolio");
    define("MYSQL_PASS", "systeem");
}
else if(PORTFOLIO_DATABASE_MODE === PORTFOLIO_MODE_SERVER_REMOTE)
{
    define("DATABASE_NAME", "db219753_portfolio_systeem");
    define("MYSQL_HOST" , "mysql765.cp.hostnet.nl");
    define("MYSQL_PORT", 3306);
    define("MYSQL_USER", "u219753_pfs");
    define("MYSQL_PASS", "{ix38ZA(XF8tRK|o");
}
else        //PORTFOLIO_MODE_SERVER
{
    define("DATABASE_NAME", "db219753_portfolio_systeem");
    define("MYSQL_HOST", "mysql765int.cp.hostnet.nl");
    define("MYSQL_PORT", 3306);
    define("MYSQL_USER", "u219753_pfs");
    define("MYSQL_PASS", "{ix38ZA(XF8tRK|o");
}
define("TABLE_USER", "gebruiker");
define("TABLE_MATERIAL", "materiaal");
define("TABLE_GRADE", "cijfer");
define("TABLE_SUBJECT", "vak");
define("TABLE_MESSAGE", "bericht");
define("TABLE_GUESTBOOK", "gastenboek");
define("TABLE_MATERIAL_SUBJECT", "materiaal_vak");
define("TABLE_USER_SUBJECT", "gebruiker_vak");
define("PORTFOLIO_UPLOAD_DIR", "files");
define("SITE_HTTP_NAME", "http://ons-portfolio.nl/");