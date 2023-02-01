<?php
function isActive($pagename)
{
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo "active";
    }
}
function checkSession()
{
    if (basename($_SERVER['PHP_SELF']) != "signin.php" && basename($_SERVER['PHP_SELF']) != "signup.php") {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['username'])) {
            header("Location: signin.php");
            exit();
        }
        return true;
    }
    return false;
}
