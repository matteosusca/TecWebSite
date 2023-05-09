<?php 


// $session_duration = 30 * 60; // 30 minutes
// session_set_cookie_params($session_duration);
define("UPLOAD_DIR", "./upload/");
require_once("db/database.php");
require_once("utils/functions.php");
$dbh = new DatabaseHelper("url", "user", "pw", "table", 3306);
//if session user exist define user
if (!empty($_POST['esci'])) {
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
