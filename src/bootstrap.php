<?php 
session_start();

// $session_duration = 30 * 60; // 30 minutes
// session_set_cookie_params($session_duration);

define("UPLOAD_DIR", "./upload/");
require_once("db/database.php");
require_once("utils/functions.php");
$dbh = new DatabaseHelper("sysosus.win", "gruppoweb", "pass123", "tw_db", 3306);
$salt = "KQxHebO0ECSTzYy";
?>