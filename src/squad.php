<?php

require_once 'bootstrap.php';

if (!empty($_GET['squad_id'])) {
    $squad = $dbh->getSquad($_GET['squad_id']);
    if($squad){
        $title = $squad->getName() . "'s page";
    } else {
        header("Location: index.php?error=1");
    }
}else {
    header("Location: index.php?error=1");
}

if (!empty($_POST['save'])) {
    // change squad picture
    if (isset($_FILES['squadPicture']) && is_uploaded_file($_FILES['squadPicture']['tmp_name']) && $_FILES['squadPicture']['error'] == 0) {
        $dbh->setSquadPicture($squad->getId(), $_FILES['squadPicture']);
    }
    //change name
    if (!empty($_POST['name'])) {
        $dbh->setSquadName($squad->getId(), $_POST['name']);
    }
    //change description
    if (!empty($_POST['description'])) {
        print("Descrizione");
        $dbh->setSquadDescription($squad->getId(), $_POST['description']);
    }
    //change permissions for users
    if (!empty($_POST['user']) && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'admin':
                if (!$dbh->setUserAdmin($_POST['user'], $squad->getId())) {
                    alert("Unable to make " .$_POST['user'] . " admin");
                }
                break;
            case 'member':
                if (!$dbh->setUserMember($_POST['user'], $squad->getId())) {
                    alert("Unable to make " .$_POST['user'] . " member");
                } 
                break;
            case 'remove':
                if (!$dbh->removeUserFromSquad($_POST['user'], $squad->getId())) {
                    alert("Unable to remove " .$_POST['user'] . " member");
                }
                break;
        }
    }
}
if (!empty($_POST['add'])) {
    if (isset($_POST['user_friend']) && isset($_POST['role'])) {
        if (!$dbh->addUserToGroup($squad->getId(), $_SESSION['username'], $_POST['user_friend'], $_POST['role'])) {
            alert("Unable to add " .$_POST['user_friend'] . " to squad");
        }
    } else if (isset($_POST['searched_user'])  && isset($_POST['role'])) {
        if ($dbh->addUserToGroup($squad->getId(), $_SESSION['username'], $_POST['searched_user'], $_POST['role'])) {
            alert("Unable to add " .$_POST['searched_user'] . " to squad");
        }
    } 
}
if (!empty($_POST['invita'])) {
    $dbh->inviteUserToEvent($_POST['event'], $squad->getId(), $_POST['user'] );
}
if (!empty($_POST['submit-event'])) {
    $dbh->createEvent($_POST['id'], $_POST['name'], $_POST['event-description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $user->getUsername());
}
if (!empty($_POST['submit-post'])) {
    $dbh->createPost($user->getUsername(), $_POST['post-description'], $_FILES['post-file']);
}
if (!empty($_POST['delete'])) {
    $dbh->removeSquad($_POST['id']);
    header("Location: index.php");
}
if(!empty($_POST['leave'])){
    $dbh->removeUserFromSquad($_SESSION['username'], $squad->getId());
    header("Location: index.php");
}

$templateParams["title"] = $title;
$templateParams["squad"] = $squad;
$templateParams["userCanEdit"] = $dbh->checkUserPermissionsForSquad($_SESSION["username"], $squad->getId());
$templateParams["members"] = $dbh->getMembers($squad->getId());
$templateParams["post"] = $dbh->getSquadPosts($squad->getId());
$templateParams["event"] = $dbh->getSquadEvents($squad->getId());
$templateParams["friends"] = $dbh->getFriends($_SESSION["username"]);
$templateParams["isUserCreator"] = $dbh->checkIsUserCreator($_SESSION["username"], $squad->getId());
$templateParams["left-aside"] = "left-aside.php";
$templateParams["main"] = "main.php";
$templateParams["right-aside"] = "right-aside.php";
$templateParams["js"] = array("https://unpkg.com/@popperjs/core@2", "https://unpkg.com/tippy.js@6", "js/get_active_users.js", "js/handle_like.js");

require 'templates/base.php';

?>