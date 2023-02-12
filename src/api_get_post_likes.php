<?php 
require_once 'bootstrap.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_post = json_decode(file_get_contents('php://input'), true)['id_post'];
    $likes = $dbh->getPostLikes($id_post);
    header('Content-Type: application/json');
    echo json_encode($likes);
}
?>