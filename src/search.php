<?php

require_once 'bootstrap.php';

if(isset($_GET['name'])){
    $name = $_GET['name'];
    $user = $dbh->getUser($name);
    $squads = $dbh->getSquads($name);
    $title = "Results for " . $name;
} else{
    $title = "Nothing to show here";
    header("Location: search.php?error=2");
}

$templateParams["title"] = $title;
$templateParams["user"] = $user;
$templateParams["squads"] = $squads;
$templateParams["main"] = "main.php";

require 'templates/base.php';

?>
