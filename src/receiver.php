<?php
require_once 'bootstrap.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST["data"];
    $dbh->setUserPosition($data, $_SESSION['username']);
}
?>