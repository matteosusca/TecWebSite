<?php
require_once 'bootstrap.php';
header('Content-Type: application/json');
echo json_encode($_SESSION['username']);
?>