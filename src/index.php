<?php
require_once 'bootstrap.php';

if (!empty($_POST['submit-post'])) {
    $dbh->createPost($user->getUsername(), $_POST['post-description'], $_FILES['post-file']);
}

$templateParams["title"] = "Home";
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";
$templateParams["post"] = $dbh->getPostOrderByDate($_SESSION["username"]);
$templateParams["event"] = $dbh->getEventsOrderByDate($_SESSION["username"]);
$templateParams["friends"] = $dbh->getFriends($_SESSION["username"]);
$templateParams["squads"] = $dbh->getSquadsByUser($_SESSION["username"]);

$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/get_active_users.js");
require 'templates/base.php';
?>