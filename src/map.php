<?php
require_once 'bootstrap.php';

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($user->getUsername()));

header('Content-Type: application/json');
$positions_json = json_encode($positions);

$templateParams["title"] = "Map";
$templateParams["body"] = "body.php";
$templateParams["js"] = array("js/localization.js","https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize","https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js");

require 'templates/base.php';
