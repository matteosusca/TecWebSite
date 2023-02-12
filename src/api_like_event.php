<?php 
require_once 'bootstrap.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_post = $data['id_post'];
    $alreadyLiked = $data['alreadyLiked']; // if isLike is true, then the user is liking the post, otherwise he is unliking it
    !$alreadyLiked ? $dbh->likePost($id_post, $_SESSION['username']) : $dbh->unlikePost($id_post, $_SESSION['username']);
}
?>