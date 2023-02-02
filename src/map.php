<?php
require_once 'bootstrap.php';
$user = $dbh->getUser($_SESSION['username']);

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($user->getUsername()));

header('Content-Type: application/json');
$positions_json = json_encode($positions);

$templateParams["title"] = "Map";
$templateParams["main"] = "main.php";

require 'templates/base.php';
?>
