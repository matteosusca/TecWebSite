<aside class="col-2 p-3 mh-100 shadow overflow-auto sticky-lg-top">
    <div class="h-100 offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <?php
        if (basename($_SERVER['PHP_SELF']) == "index.php" || basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
            <div class="h-100">
                <div class=" h-50 overflow-auto">
                    <h5>Friends</h5>
                    <ul class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["friends"] as $friend) { ?>
                            <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $friend->getUsername() ?>">
                                <img src=<?php echo $friend->getprofilePicture() ?> alt="" width=" 32" height="32" class="rounded-circle">
                                <?php echo $friend->getUsername()  ?></a>
                        <?php }
                        ?>
                    </ul>
                </div>
                <div class=" h-50 overflow-auto">
                    <h5>Squads</h5>
                    <ul class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["squads"] as $squad) { ?>
                            <a class="list-group-item list-group-item-action" href="squad.php?squad_id=<?php echo $squad->getId() ?>">
                                <img src=<?php echo $squad->getPicture() ?> alt="" width="32" height="32" class="rounded-circle">
                                <?php echo $squad->getName() ?></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php
        } else if (basename($_SERVER['PHP_SELF']) == "squad.php") { ?>
            <div class=" h-100 overflow-auto">
                <h5>Members</h5>
                <ul class="list-group list-group-flush offcanvas-body">
                    <?php foreach ($templateParams["members"] as $member) { ?>
                        <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $member->getUsername() ?>">
                            <img src=<?php echo $member->getprofilePicture() ?> alt="" width=" 32" height="32" class="rounded-circle">
                            <?php echo $member->getUsername()  ?></a>
                    <?php }
                    ?>
                </ul>
            </div>
        <?php
        } ?>
    </div>
</aside>