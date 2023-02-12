<?php

require_once 'bootstrap.php';

if(isset($_GET['name'])){
    $name = $_GET['name'];
    $users = $dbh->searchUser($name);
    $squads = $dbh->searchSquads($name);
    $title = "Results for " . $name;
} else{
    $title = "Nothing to show here";
    header("Location: search.php?error=2");
}

$templateParams["title"] = $title;
$templateParams["users"] = $users;
$templateParams["squads"] = $squads;
$templateParams["main"] = "main.php";

require 'templates/base.php';

?>
