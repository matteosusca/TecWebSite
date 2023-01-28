<?php

function isActive($pagename)
{
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo "active";
    }
}
function checkSession()
{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['username'])) {
        header("Location: signin.php");
        exit();
    }
}
function showEvents($events)
{
    foreach ($events as $event) {
        echo $event->showEvent();
    }
}

function showPosts($posts)
{
    foreach ($posts as $post) {
        echo $post->showPost();
    }
}

function getFriends($dbh, $username)
{
    echo '<h5>Friends</h5>
    <ul class="list-group list-group-flush offcanvas-body">';
    $friends = $dbh->getFriends($username);
    foreach ($friends as $friend) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user=' . $dbh->getUser($friend)->getUsername() . '"> 
        
        <img src="' . $dbh->getMediaUrl($dbh->getUser($friend)->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">'

            . $dbh->getUser($friend)->getUsername() . '</a>';
    }
    echo '</ul>';
}

function getSquads($dbh, $username)
{
    echo '<h5>Squads</h5>
    <ul class="list-group list-group-flush offcanvas-body">';
    $squads = $dbh->getSquadsByUser($username);
    foreach ($squads as $squad) {
        echo '<a class="list-group-item list-group-item-action" href="squad.php?name=' . $dbh->getSquad($squad)->getName() . '">
        
        <img src="' . $dbh->getMediaUrl($dbh->getSquad($squad)->getPicture()) . '" alt="" width="32" height="32" class="rounded-circle">'

            . $dbh->getSquad($squad)->getName() . '</a>';
    }
    
    echo '</ul>';

}

function getMembers($dbh, $squadProfile)
{
    echo '<h5>Members</h5>
    <ul class="list-group list-group-flush offcanvas-body">';
    foreach ($squadProfile->getMembers() as $member) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user=' . $dbh->getUser($member)->getUsername() . '">

            <img src="' . $dbh->getMediaUrl($dbh->getUser($member)->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">'
            . $member . '</a>';
    }
    
    echo '</ul>';

}