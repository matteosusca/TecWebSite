<?php
require_once("bootstrap.php");



if (isset($_GET['sender']) || true) {
    $sender = $_GET['sender'];
    $currentUser = $user->getUsername();    
    $dbh->declineRequest($currentUser, $sender);
}
?>