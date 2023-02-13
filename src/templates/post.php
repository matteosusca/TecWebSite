<?php $post = $templateParams["post"];?>
<div class="card my-2">
    <div class="card-header d-flex ">
        <img src=<?php echo $dbh->getUser($post->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="post author profile picture" width="64" height="64">
        <div class="d-flex flex-column px-2">
            <h3 class="card-title"><?php echo $post->getUsername() ?></h3>
            <p class="card-text"><?php echo $post->getDate() ?></p>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?php echo $post->getDescription() ?></p>
    </div>
    <img src=<?php echo $post->getUrlMedia() ?> class="object-fit-contain" alt="post media" height="455">
    <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly">
        <button type="button" class="btn btn-outline-secondary border-0" name="like-btn" value="<?php echo $post->getId() ?>">
            <?php if ($dbh->isLiked($post->getId(), $user->getUsername())) { ?>
                <em class="bi bi-hand-thumbs-up-fill d-block position-relative">
                <?php } else { ?>
                    <em class="bi bi-hand-thumbs-up d-block position-relative">
                    <?php } ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="<?php echo $post->getId() ?>-notification-like-count"></span></em>
                    like
        </button>
        <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target="#notification<?php echo $post->getId() ?>" aria-expanded="false" aria-controls="<?php echo $post->getId() ?>"><em class="bi bi-pencil-square d-block"></em>comments</button>
    </div>
    <div class="collapse multi-collapse" id="notification<?php echo $post->getId() ?>">
        <?php if (isset($_POST['submitComment' . $post->getId()])) {
            $dbh->createComment($user->getUsername(), $post->getId(), $_POST['body']);
        } ?>
        <div class="card m-2">
            <div class="card-header ">
                <h4 class="card-title">Crea commento</h4>
            </div>
            <div class="card-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="notification_comment_body_post#<?php echo $post->getId() ?>" placeholder="Scrivi un commento" name="body" required>
                        <label for="notification_comment_body_post#<?php echo $post->getId() ?>">Scrivi un commento</label>
                    </div>
                    <button class="btn btn-outline-secondary mt-2 w-100" type="submit" value="Pubblica" name="submitComment<?php echo $post->getId() ?>">Pubblica</button>
                </form>
            </div>
        </div>
        <?php foreach ($dbh->getPostComments($post->getId()) as $comment) { ?>
            <div class="card my-1 border-0">
                <div class="d-flex align-items-center px-2 border-0">
                    <img src=<?php echo $dbh->getUser($comment->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="comment author profile picture" width="32" height="32">
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
    </div>
</div>