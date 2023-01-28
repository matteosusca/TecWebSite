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

function getFriends($friends)
{
    foreach ($friends as $friend) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user='
            . $friend->getUsername() . '"><img src="'
            . $friend->getProfilePicture() . '" alt="" width="32" height="32" class="rounded-circle">'
            . $friend->getUsername() . '</a>';
    }
}

function getSquads($squads)
{
    foreach ($squads as $squad) {
        echo '<a class="list-group-item list-group-item-action" href="squad.php?name='
            . $squad->getName() . '"><img src="'
            . $squad->getPicture() . '" alt="" width="32" height="32" class="rounded-circle">'
            . $squad->getName() . '</a>';
    }
}

function getMembers($members)
{
    foreach ($members as $member) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user='
            . $member->getUsername() . '"><img src="'
            . $member->getProfilePicture() . '" alt="" width="32" height="32" class="rounded-circle">'
            . $member->getUsername() . '</a>';
    }
}
