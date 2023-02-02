<?php
require_once 'bootstrap.php';

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}

if (!empty($_POST['invita'])) {
    $dbh->inviteUserToEvent($_POST['event'], $squad_id, $_POST['user'] );
}
$squad = $dbh->getSquad($squad_id);

$templateParams["title"] = "Invite user to event";
$templateParams["body"] = "body.php";
$templateParams["squad"] = $squad;
$templateParams["event"] = $dbh->getSquadEvents($squad->getID());

require 'templates/base.php';
?>
