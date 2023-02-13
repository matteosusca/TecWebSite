<?php $event = $templateParams["event"];?>
<div class="card m-2">
    <div class="card-header">
        <div class="d-flex align-items-center px-2 border-0">
            <img src=<?php echo $dbh->getUser($event->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="event author profile picture" width="32" height="32">
            <div class="d-flex flex-column px-2">
                <p class="card-title"><?php echo $event->getName() ?>(<?php echo $event->getUsername() ?>)</p>
                <p class="card-text">dal <?php echo $event->getDateOfEventStart() ?> al <?php echo $event->getDateOfEventEnd() ?></p>
            </div>
        </div>
    </div>
    <div class="card card-body">
        <p class="card-text"><?php echo $event->getDescription() ?></p>
        <?php if (isset($templateParams['friends'])) { ?>
            <div class="flex-fill overflow-auto">
                <h2 class="offcanvas-title">Partecipants</h2>
                <div class="list-group list-group-flush offcanvas-body">
                    <?php foreach ($dbh->getEventParticipants($event->getIdEvent()) as $user_pic) { ?>
                        <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $user_pic->getUsername() ?>">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex position-relative">
                                    <img src=<?php echo $user_pic->getprofilePicture() ?> alt="<?php echo $user_pic->getUsername() ?> profile picture" width="32" height="32" class="rounded-circle">
                                </div>
                                <?php echo $user_pic->getUsername() ?>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="card card-footer">
        <form action="" method="post" class="m-2">
            <?php $isRegistered = $dbh->isRegisteredToEvent($user->getUsername(), $event->getIdEvent()); ?>
            <input type="hidden" name="registration_action" value=<?php if ($isRegistered) {
                                                                        echo "unregister";
                                                                    } else {
                                                                        echo "register";
                                                                    } ?>>
            <input type="hidden" name="event_id" value=<?php echo $event->getIdEvent(); ?>>
            <input class="btn btn-secondary w-100" type="submit" <?php if ($isRegistered) {
                                                                        echo "value='Unregister'";
                                                                    } else {
                                                                        echo "value='Register'";
                                                                    } ?>>
        </form>
    </div>
</div>