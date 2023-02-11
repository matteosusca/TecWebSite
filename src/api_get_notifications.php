<?php

// Include the file.php script to get access to the $dbh object
require_once 'bootstrap.php';
//checkSession();

// Get the user from the session
$user = $_SESSION["username"];

// Check if the user is authorized to view the notifications
if (!$user) {
  // Return an error if the user is not authorized
  header("HTTP/1.1 401 Unauthorized");
  echo "Unauthorized";
  exit;
}

try {
  $notifications = $dbh->getNotifications($user);
} catch (Exception $e) {
  // Return an error if the database query failed
  header("HTTP/1.1 500 Internal Server Error");
  echo "Error getting notifications: " . $e->getMessage();
  exit;
}

// Return the notifications as JSON
header("Content-Type: application/json");
echo json_encode($notifications);

?>