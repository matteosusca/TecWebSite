<?php
require_once 'bootstrap.php';

if (isset($_GET['user'])) {
    $userProfile = $dbh->getUser($_GET['user']);
    if ($userProfile) {
        $title = $userProfile->getUsername() . "'s profile";
    } else {
        header("Location: index.php?error=1");
    }
} else {
    header("Location: index.php?error=1");
}

if (isset($_POST['aggiungi'])) {
    $dbh->addFriendRequest($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
} else if (isset($_POST['rimuovi'])) {
    $dbh->removeFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
}

$update = false;
//check if file is uploaded
if (isset($_FILES['profilePicture']) && is_uploaded_file($_FILES['profilePicture']['tmp_name']) && $_FILES['profilePicture']['error'] == 0) {
    if (!$dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture'])) {
        alert("Unable to update profile picture");
    }
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
    $dbh->setMail($_SESSION['username'], $_POST['email']);
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
