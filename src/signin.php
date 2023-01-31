<?php

require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    $enc_passw = md5($_POST['password'] . $salt);
    if ($dbh->checkLogin($_POST['user'], $enc_passw)) {
        $_SESSION['username'] = $_POST['user'];
        header("Location: index.php");
    } else {
        header("Location: login.php?error=1");
    }
} else if (!empty($_POST['esci'])) {
    session_start();
    session_destroy();
    header("Location: signin.php");
}

$templateParams["title"] = "Sign in";
$templateParams["main"] = "main.php";

require 'templates/base.php';

?>
