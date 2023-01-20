<?php
require_once 'bootstrap.php';

$enc_passw = md5($_POST['password']);

if($dbh->signUpUser($_POST['username'], $_POST['email'], $enc_passw, $_POST['name'], $_POST['surname'], $_POST['date_of_birth'])){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $enc_passw;
    header("Location: index.php");
}else{
    header("Location: signup.php?error=1");
}