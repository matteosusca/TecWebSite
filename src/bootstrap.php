<?php 


// $session_duration = 30 * 60; // 30 minutes
// session_set_cookie_params($session_duration);
define("UPLOAD_DIR", "./upload/");
require_once("db/database.php");
require_once("utils/functions.php");
$dbh = new DatabaseHelper("sysosus.win", "gruppoweb", "pass123", "tw_db", 3306);
//if session user exist define user
if (isset($_POST['esci'])) {
    session_start();
    session_destroy();
    header("Location: signin.php");
}else if(checkSession()){
    $user = $dbh->getUser($_SESSION['username']);
}else{
    session_start();
}





$salt = "KQxHebO0ECSTzYy";
?>