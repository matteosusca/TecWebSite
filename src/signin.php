<?php
require 'bootstrap.php';

$enc_passw = md5($_POST['password']);

if($dbh->checkLogin($_POST['username'], $_POST['email'], $enc_passw)){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $enc_passw;
    header("Location: index.php");
}else{
    header("Location: login.php?error=1");
}
?>