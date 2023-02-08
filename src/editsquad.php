<?php
require_once 'bootstrap.php';

$squad_id = $_POST['id'];

if (!empty($_POST['save'])) {

    // change squad picture
    if (isset($_FILES['squadPicture']) && is_uploaded_file($_FILES['squadPicture']['tmp_name']) && $_FILES['squadPicture']['error'] == 0) {
        print("Immagine");
        $dbh->setSquadPicture($squad_id, $_FILES['squadPicture']);
    }

    //change name
    if (!empty($_POST['name'])) {
        $dbh->setSquadName($squad_id, $_POST['name']);
    }

    //change description
    if (!empty($_POST['description'])) {
        print("Descrizione");
        $dbh->setSquadDescription($squad_id, $_POST['description']);
    }

    //change permissions for users
    if (!empty($_POST['user']) && !empty($_POST['action'])) {
        switch ($_POST['action']) {
            case 'admin':
                if ($dbh->setUserAdmin($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " made admin");
                } else {
                    print("Unable to make " . $_POST['user'] . " admin");
                }
                break;
            case 'member':
                if ($dbh->setUserMember($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " made member");
                } else {
                    print("Unable to make " . $_POST['user'] . " member");
                }
                break;
            case 'remove':
                if ($dbh->removeUserFromSquad($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " removed");
                } else {
                    print("Unable to remove " . $_POST['user']);
                }
                break;
        }
    }
    header("Location: squad.php?squad_id=" . $squad_id);
}

$squad = $dbh->getSquad($squad_id);

$templateParams["title"] = "Edit Squad";
$templateParams["body"] = "body.php";
$templateParams["squad"] = $squad;

require 'templates/base.php';

?>

