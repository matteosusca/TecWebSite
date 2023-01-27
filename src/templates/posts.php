<?php
        $friends = $dbh->getFriends($_SESSION['username']);
        foreach ($friends as $friend) {
            $posts=$dbh->getPostOrderByDate($_SESSION['username']);
            foreach ($posts as $post) {
                echo $post->showPost();
            }
        }


?>