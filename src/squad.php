<?php

require_once 'bootstrap.php';

if (isset($_GET['squad_id'])) {
    $squad_id = $_GET['squad_id'];
    $squad = $dbh->getSquad($squad_id);
    $title = $squad->getName() . "'s page";
} else {
    header("Location: squad.php?error=2");
}

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
}
if (!empty($_POST['add'])) {
    if (!empty($_POST['user_friend']) && !empty($_POST['role'])) {
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['user_friend'], $_POST['role'])) {
            print($_POST['user_friend'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['user_friend'] . " to squad");
        }
    } else if (!empty($_POST['searched_user'])  && !empty($_POST['role'])) {
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['searched_user'], $_POST['role'])) {
            print($_POST['searched_user'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['searched_user'] . " to squad");
        }
    } 
}
if (!empty($_POST['invita'])) {
    $dbh->inviteUserToEvent($_POST['event'], $squad_id, $_POST['user'] );
}
if (!empty($_POST['submit-event'])) {
    $dbh->createEvent($_POST['id'], $_POST['name'], $_POST['event-description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $user->getUsername());
}

if (!empty($_POST['submit-post'])) {
    $dbh->createPost($user->getUsername(), $_POST['post-description'], $_FILES['post-file']);
}

$templateParams["title"] = $title;
$templateParams["squad"] = $squad;
$templateParams["userCanEdit"] = $dbh->checkUserPermissionsForSquad($_SESSION["username"], $squad->getId());
$templateParams["members"] = $dbh->getMembers($squad->getId());
$templateParams["post"] = $dbh->getSquadPosts($squad->getId());
$templateParams["event"] = $dbh->getSquadEvents($squad->getId());
$templateParams["friends"] = $dbh->getFriends($_SESSION["username"]);
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";
<<<<<<< HEAD
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "https://unpkg.com/@popperjs/core@2", "https://unpkg.com/tippy.js@6", "js/get_active_users.js", "js/handle_like.js");
=======
$templateParams["js"] = array("js/get_active_users.js", "js/handle_like.js");
>>>>>>> main

require 'templates/base.php';

?>