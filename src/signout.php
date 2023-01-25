<?php
require_once 'bootstrap.php';
checkSession();

session_destroy();
header("Location: signin.php");
