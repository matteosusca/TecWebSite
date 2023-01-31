<?php

require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    $enc_passw = md5($_POST['password'] . $salt);
    if ($dbh->signUpUser($_POST['username'], $_POST['email'], $enc_passw, $_POST['name'], $_POST['surname'], $_POST['date_of_birth'], $_FILES['profilefile'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $enc_passw;
        header("Location: index.php");
    } else {
        header("Location: signup.php?error=1");
    }
}

$templateParams["title"] = "Sign up";
$templateParams["main"] = "main.php";

require 'templates/base.php';

?>
