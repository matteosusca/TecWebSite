<?php

require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    if ($dbh->signUpUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date_of_birth'], $_FILES['profilefile'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $enc_passw;
        $dbh->setLastActivity($_POST['user'], date("Y-m-d H:i:s", time()));
        header("Location: index.php");
    } else {
        header("Location: signup.php?error=1");
    }
}

$templateParams["title"] = "Sign up";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>
