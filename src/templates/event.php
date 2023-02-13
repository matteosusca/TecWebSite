<?php $eventNotification = $templateParams["event"];?>
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
    </div>
</div>