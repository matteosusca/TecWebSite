<?php
require_once 'bootstrap.php';
if(!isset($_SESSION['username'])){
    header("Location: signin.html");
    exit();
}
?>