<aside class="col-12 col-lg-2 mh-100 shadow overflow-auto sticky-lg-top">
    <div class="h-100 offcanvas-lg offcanvas-end p-3" tabindex="-1" id="offcanvasResponsive">
        <div class="offcanvas-header">
            <label class="visually-hidden" for="closerightaside">Close Friends</label>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" id="closerightaside"></button>
        </div>
        <div class="h-100 d-flex flex-column">
            <?php if (isset($templateParams['friends'])) { ?>
                <div class="flex-fill overflow-auto">
                    <h2 class="offcanvas-title">Friends</h2>
                    <div class="list-group list-group-flush offcanvas-body">
                        <?php foreach ($templateParams["friends"] as $user) { 
                            require "user-icon.php";    
                        } ?>
                    </div>
                </div>
            <?php }
            if (isset($templateParams['squads'])) { ?>
                <div class="flex-fill overflow-auto">
                    <h2 class="offcanvas-title">Squads</h2>
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
                    <h2 class="offcanvas-title">Members</h2>
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