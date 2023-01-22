<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("db/database.php");
$dbh = new DatabaseHelper("sysosus.win", "gruppoweb", "pass123", "tw_db", 3306);
require_once("checkSession.php");
?>