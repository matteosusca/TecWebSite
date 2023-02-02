<?php
require_once 'bootstrap.php';

$templateParams["title"] = "Home";
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";
$templateParams["post"] = $dbh->getPostOrderByDate($_SESSION["username"]);
$templateParams["event"] = $dbh->getEventsOrderByDate($_SESSION["username"]);
$templateParams["friends"] = $dbh->getFriends($_SESSION["username"]);
$templateParams["squads"] = $dbh->getSquadsByUser($_SESSION["username"]);

//$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js","js/index.js");
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/retrieve_users_status.js");
require 'templates/base.php';
?>