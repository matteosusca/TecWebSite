<?php
//var_dump($comment);
if (isset($comment)) { ?>
    <div class="card my-1 border-0">
        <div class="d-flex align-items-center px-2 border-0">
            <img src=<?php echo $dbh->getUser($comment->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="..." width="32" height="32" />
            <div class="d-flex flex-column px-2">
                <p class="card-title"><?php echo $comment->getUsername() ?></p>
                <p class="card-text"><?php echo $comment->getDate() ?></p>
            </div>
            <div class="card card-body">
                <p class="card-text"><?php echo $comment->getBody() ?></p>
            </div>
        </div>
    </div>
<?php } ?>