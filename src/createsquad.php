<?php
require_once 'bootstrap.php';

if ($dbh->createSquad($_POST['name'], $_POST['description'], $_SESSION['username'])) {
    header("Location: squadpage.php");
} else {
    header("Location: createsquad.php?error=1");
}

?>