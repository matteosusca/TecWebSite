<?php
require_once 'bootstrap.php';

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

$templateParams["title"] = "Edit Profile";
$templateParams["body"] = "body.php";

require 'templates/base.php';
?>

