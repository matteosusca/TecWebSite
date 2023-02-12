<?php
require_once 'bootstrap.php';

checkSession();


$usernames = $dbh->getFriendsUsername($user->getUsername());
array_push($usernames, $user->getUsername());
$positions = $dbh->getUsersPosition($usernames);

header('Content-Type: application/json');

echo json_encode($positions);

?>
