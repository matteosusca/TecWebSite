<?php
require_once 'bootstrap.php';

if (!empty($_POST['save'])) {
    $squad_id = $dbh->createSquad($_POST['name'], $_POST['description'], $_FILES['squadPicture'], $_SESSION['username']);
    header("Location: squad.php?squad_id=" . $squad_id);
}

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

$templateParams["js"] = array("https://unpkg.com/@popperjs/core@2", "https://unpkg.com/tippy.js@6", "js/get_active_users.js", "js/handle_like.js");
require 'templates/base.php';
?>