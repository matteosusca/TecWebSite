<?php

require_once 'bootstrap.php';

if (isset($_GET['squad_id'])) {
    $squad_id = $_GET['squad_id'];
    $squad = $dbh->getSquad($squad_id);
    $title = $squad->getName() . "'s page";
} else {
    header("Location: squad.php?error=2");
}

$templateParams["title"] = $title;
$templateParams["squad"] = $squad;
$templateParams["userCanEdit"] = $dbh->checkUserPermissionsForSquad($_SESSION["username"], $squad->getId());
$templateParams["members"] = $dbh->getMembers($squad->getId());
$templateParams["post"] = $dbh->getSquadPosts($squad->getId());
$templateParams["event"] = $dbh->getSquadEvents($squad->getId());
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/get_active_users.js", "js/handle_like.js");

require 'templates/base.php';

?>