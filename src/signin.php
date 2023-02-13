<?php

require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    if ($dbh->checkLogin($_POST['user'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['user'];
        $dbh->setLastActivity($_POST['user'], date("Y-m-d H:i:s", time()));
        header("Location: index.php");
    } else {
        header("Location: login.php?error=1");
    }
}

$templateParams["title"] = "Sign in";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>
