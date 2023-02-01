<?php
require_once 'bootstrap.php';

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($_SESSION['username']->getUsername()));
$positions_json = json_encode($positions);

$templateParams["title"] = "Map";
$templateParams["main"] = "main.php";

require 'templates/base.php';
?>
