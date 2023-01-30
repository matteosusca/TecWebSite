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
        $post->showPost();
    }
}

function getFriends($friends)
{
    foreach ($friends as $friend) {
        echo $friend->showUser();
    }
}

function getSquads($squads)
{
    foreach ($squads as $squad) {
        echo $squad->showSquad();
    }
}

function getMembers($members)
{
    foreach ($members as $member) {
        echo $member->showUser();
    }
}
