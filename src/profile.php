<?php
require_once 'bootstrap.php';

if (isset($_GET['user'])) {
    $userProfile = $_GET['user'];
    $userProfile = $dbh->getUser($userProfile);
    if (!$userProfile) {
        $title = "Profile not found";
        header("location: 404.php");
    } else {
        $title = $userProfile->getUsername() . "'s profile";
    }
    if (isset($_POST['aggiungi'])) {
        $dbh->addFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    } else if (isset($_POST['rimuovi'])) {
        $dbh->removeFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    }
} else {
    $title = "Profile not found";
    header("location: 404.php");
}

$templateParams["title"] = $title;
$templateParams["user"] = $userProfile;
$templateParams["friends"] = $dbh->getFriends($userProfile->getUsername());
$templateParams["squads"] = $dbh->getSquadsByUser($userProfile->getUsername());
$templateParams["post"] = $dbh->getUserPosts($userProfile->getUsername());
$templateParams["event"] = $dbh->getUserEvents($userProfile->getUsername());
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";

$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/get_active_users.js", "js/handle_like.js");


require 'templates/base.php';

?>
