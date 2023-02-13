<?php

require_once 'bootstrap.php';

if (isset($_POST['submit'])) {
    if ($dbh->checkLogin($_POST['user'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['user'];
        header("Location: index.php");
    } else {
        alert("error in signin");
    }
}

$templateParams["title"] = "Sign in";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>
