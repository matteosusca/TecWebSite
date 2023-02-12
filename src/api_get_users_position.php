<?php
require_once 'bootstrap.php';

checkSession();

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($user->getUsername()));

header('Content-Type: application/json');

echo json_encode($positions);

?>
