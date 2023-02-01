<?php
require_once 'bootstrap.php';

if (!empty($_POST['save'])) {
    $squad_id = $dbh->createSquad($_POST['name'], $_POST['description'], $_FILES['squadPicture'], $_SESSION['username']);
    header("Location: squad.php?squad_id=" . $squad_id);
}

$templateParams["title"] = "Create Squad";
$templateParams["body"] = "body.php";

require 'templates/base.php';

?>

