<?php

require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    if ($dbh->checkLogin($_POST['user'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['user'];
        header("Location: index.php");
    } else {
        header("Location: login.php?error=1");
    }
}

$templateParams["title"] = "Sign in";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>
