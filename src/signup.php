<?php

require_once 'bootstrap.php';

if (isset($_POST['submit'])) {
    if ($dbh->signUpUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date_of_birth'], $_FILES['profilefile'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
    } else {
        alert("error in signup");
    }
}

$templateParams["title"] = "Sign up";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>
