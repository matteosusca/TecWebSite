<?php
require_once 'bootstrap.php';

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}

if (!empty($_POST['save'])) {
    if (!empty($_POST['user_friend']) && !empty($_POST['role'])) {
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['user_friend'], $_POST['role'])) {
            print($_POST['user_friend'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['user_friend'] . " to squad");
        }
    } else if (!empty($_POST['searched_user'])  && !empty($_POST['role'])) {
        print("zio canta");
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['searched_user'], $_POST['role'])) {
            print($_POST['searched_user'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['searched_user'] . " to squad");
        }
    } 
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}
$templateParams["title"] = "Add user to group";
$templateParams["main"] = "main.php";
$templateParams["squad"] = $dbh->getSquad($squad_id);
$templateParams["user"] = $dbh->getUser($_SESSION['username']);

require 'templates/base.php';

?>