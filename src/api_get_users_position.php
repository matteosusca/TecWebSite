<?php
require_once 'bootstrap.php';

if (checkSession()) {
    $user = $dbh->getUser($_SESSION['username']);
}
$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($user->getUsername()));

header('Content-Type: application/json');

echo json_encode($positions);

?>
