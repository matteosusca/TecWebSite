<?php
            $posts=$dbh->getPostOrderByDate($_SESSION['username']);
            foreach ($posts as $post) {
                echo $post->showPost();
            }
    
            
            

?>

