<?php
require_once 'class/post.php';
if (isset($post) && isset($dbh)) { ?>
    <div class="card my-2">
        <div class="card-header d-flex ">
            <img src=<?php echo $dbh->getUser($post->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="..." width="64" height="64" />
            <div class="d-flex flex-column px-2">
                <h5 class="card-title"><?php echo $post->getUsername() ?></h5>
                <p class="card-text"><?php echo $post->getDate() ?></p>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $post->getDescription() ?></p>
        </div>
        <img src=<?php echo $post->getUrlMedia() ?> class="object-fit-contain" alt="..." height="455" />
        <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly">
            <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block" style="font-size: 1rem;"></i>like</button>
            <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
            <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comments</button>
        </div>
        <div class="collapse multi-collapse" id="multiCollapseExample1">
            <?php
            require "templates/createcomment.php";
            foreach ($dbh->getPostComments($post->getId()) as $comment) {
                require 'showcomment.php';
            }
            ?>
        </div>
    </div>
<?php } ?>