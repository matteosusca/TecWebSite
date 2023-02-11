<?php
require_once 'bootstrap.php';
header('Content-Type: application/json');
if(isset($user)) {
    echo json_encode($user);
}
?>