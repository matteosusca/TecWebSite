<?php
require_once 'bootstrap.php';

if (isset($_GET['user'])) {
    $userProfile = $_GET['user'];
    $userProfile = $dbh->getUser($userProfile);
    if (!$userProfile) {
        $title = "Profile not found";
        //header("location: 404.php");
    } else {
        $title = $userProfile->getUsername() . "'s profile";
    }
    if (isset($_POST['aggiungi'])) {
        $dbh->addFriendRequest($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    } else if (isset($_POST['rimuovi'])) {
        $dbh->removeFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    }
} else {
    $title = "Profile not found";
    //header("location: 404.php");
}
$update = false;

//check if file is uploaded
if (isset($_FILES['profilePicture']) && is_uploaded_file($_FILES['profilePicture']['tmp_name']) && $_FILES['profilePicture']['error'] == 0) {
    $dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture']);
    $update = true;
}
if (isset($_POST['name'])) {
    $dbh->setName($_SESSION['username'], $_POST['name']);
    $update = true;
}
if (isset($_POST['surname'])) {
    $dbh->setSurname($_SESSION['username'], $_POST['surname']);
    $update = true;
}
if (isset($_POST['email'])) {
    if (!$dbh->setMail($_SESSION['username'], $_POST['email'])) {
        header("Location: editprofile.php?error=1");
    }
    $update = true;
}
if($update) {
    header("Location: profile.php?user=" . $_SESSION['username']);
}

$templateParams["title"] = $title;
$templateParams["user"] = $userProfile;
$templateParams["friends"] = $dbh->getFriends($userProfile->getUsername());
$templateParams["isPendingRequest"] = $dbh->isFriendRequestPending($_SESSION['username'], $userProfile->getUsername());
$templateParams["squads"] = $dbh->getSquadsByUser($userProfile->getUsername());
$templateParams["post"] = $dbh->getUserPosts($userProfile->getUsername());
$templateParams["event"] = $dbh->getUserEvents($userProfile->getUsername());
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";

$templateParams["js"] = array("https://unpkg.com/@popperjs/core@2", "https://unpkg.com/tippy.js@6", "js/get_active_users.js", "js/handle_like.js");


require 'templates/base.php';
?>
