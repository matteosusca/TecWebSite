<?php
require_once("bootstrap.php");

if (isset($_GET['sender'])) {
    $sender = $_GET['sender'];
    $currentUser = $user->getUsername();    
    $dbh->acceptRequest($currentUser, $sender);
}
?>