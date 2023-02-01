<?php
require_once 'bootstrap.php';
//check if file is uploaded
if (isset($_FILES['profilePicture']) && is_uploaded_file($_FILES['profilePicture']['tmp_name']) && $_FILES['profilePicture']['error'] == 0) {
    $dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture']);
}
if (!empty($_POST['name'])) {
    $dbh->setName($_SESSION['username'], $_POST['name']);
}
if (!empty($_POST['surname'])) {
    $dbh->setSurname($_SESSION['username'], $_POST['surname']);
}
if (!empty($_POST['email'])) {
    if (!$dbh->setMail($_SESSION['username'], $_POST['email'])) {
        header("Location: editprofile.php?error=1");
    }
}

$templateParams["title"] = "Edit Profile";
$templateParams["body"] = "body.php";

require 'templates/base.php';
?>

