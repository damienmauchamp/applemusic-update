<?php
//date_default_timezone_set("Europe/Paris");
session_start();
require_once("functions.php");

define("DEFAULT_DATE_FORMAT", "Y-m-d");
define("DEFAULT_DATE_FORMAT_NO_SECS", "Y-m-d H:i");
define("DEFAULT_DATE_FORMAT_TIME", "Y-m-d H:i:s");
define("WEEKDAYS_NAMES", serialize(array(
    1 => "lundi",
    2 => "mardi",
    3 => "mercredi",
    4 => "jeudi",
    5 => "vendredi",
    6 => "samedi",
    7 => "dimanche"
)));
define("MONTHS_NAMES", serialize(array(
    1 => "janvier",
    2 => "février",
    3 => "mars",
    4 => "avril",
    5 => "mai",
    6 => "juin",
    7 => "juillet",
    8 => "août",
    9 => "septembre",
    10 => "octobre",
    11 => "novembre",
    12 => "décembre"
)));
define("MONTHS_NAMES_SHORT", serialize(array(
    1 => "janv.",
    2 => "févr.",
    3 => "mars",
    4 => "avr.",
    5 => "mai",
    6 => "juin",
    7 => "juil.",
    8 => "août",
    9 => "sept.",
    10 => "oct.",
    11 => "nov.",
    12 => "déc."
)));

if (isset($argv)) {
    foreach ($argv as $arg) {
        $e = explode("=", $arg);
        if (count($e) == 2)
            $_GET[$e[0]] = $e[1];
        else
            $_GET[$e[0]] = 0;
    }
}

$detect = new Mobile_Detect;
$mobile = $detect->isMobile();
//$page = isset($_GET["page"]) ? $_GET["page"] : null;
$theme = "is-music-theme";
$news = isset($_GET["refresh"]);
$full = isset($_GET["full"]);
//$news = isset($_GET["refresh"]) && $_GET["refresh"] ? $_GET["refresh"] : false;
$display = $news ? "column" : "row";
$nodisplay = isset($_GET["nodisplay"]);
//echo date(DEFAULT_DATE_FORMAT_TIME);

$idUser = isset($_SESSION["id_user"]) ? $_SESSION["id_user"] : -1;
$navTitle = (strtotime("now") < strtotime(date("Y-m-d 18:00:00")) ? "Bonjour " : "Bonsoir ") . (isset($_SESSION["prenom"]) ? $_SESSION["prenom"] : null);

//var_dump($_SESSION);
//var_dump($idUser);
//tmp
//$idUser = 2;

// run from command line :
//  php -f index.php refresh=1 full=1
