<?php
$posts=$dbh->getPostOrderByDate();
    foreach ($posts as $post) {
        echo $post->showPost();
    }

?>