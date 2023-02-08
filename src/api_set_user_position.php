<?php
require_once 'bootstrap.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true)['data'];
    $dbh->setUserPosition($data, $_SESSION['username']);
}
?>