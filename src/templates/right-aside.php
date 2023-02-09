<aside class="col-2 p-3 h-100 shadow overflow-auto sticky-lg-top">
    <div class="h-100 offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="h-100 d-flex flex-column">
            <?php if (isset($templateParams['friends'])) { ?>
                <div class="flex-fill overflow-auto">
                    <h5>Friends</h5>
                    <div class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["friends"] as $user) { 
                            require "user-icon.php";    
                        } ?>
                    </div>
                </div>
            <?php }
            if (isset($templateParams['squads'])) { ?>
                <div class="flex-fill overflow-auto">
                    <h5>Squads</h5>
                    <div class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["squads"] as $squad) { ?>
                            <a class="list-group-item list-group-item-action" href="squad.php?squad_id=<?php echo $squad->getId() ?>">
                                <img src=<?php echo $squad->getPicture() ?> alt="<?php echo $squad->getName() ?> picture" width="32" height="32" class="rounded-circle">
                                <?php echo $squad->getName() ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php }
            if (isset($templateParams['members'])) { ?>
                <div class="flex-fill overflow-auto">
                    <h5>Members</h5>
                    <div class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["members"] as $user) { 
                            require "user-icon.php";
                        } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</aside>