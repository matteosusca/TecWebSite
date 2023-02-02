<?php

require_once 'bootstrap.php';

$usersStatus = $dbh->getUsersLastActivity();

header('Content-Type: application/json');
echo json_encode($usersStatus);

?>