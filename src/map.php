<?php
require_once 'bootstrap.php';

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($_SESSION['username']));
$positions_json = json_encode($positions);

$templateParams["title"] = "Map";
$templateParams["body"] = "body.php";

require 'templates/base.php';
