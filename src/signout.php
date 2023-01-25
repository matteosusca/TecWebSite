<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';

session_destroy();
header("Location: signin.php");

?>