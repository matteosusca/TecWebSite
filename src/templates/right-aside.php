<aside class="col-2 p-3 mh-100 shadow overflow-auto sticky-lg-top">
    <div class="h-100 offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <?php
        if (basename($_SERVER['PHP_SELF']) == "index.php" || basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
            <div class="offcanvas-body h-100">
                <div class=" h-50 overflow-auto">
                    <h5>Friends</h5>
                    <ul class="list-group list-group-flush offcanvas-body">
                        <?php getFriends($templateParams["friends"]) ?>
                    </ul>
                </div>
                <div class=" h-50 overflow-auto">
                    <h5>Squads</h5>
                    <ul class="list-group list-group-flush offcanvas-body">
                        <?php getSquads($templateParams["squads"]) ?>
                    </ul>
                </div>
            </div>
        <?php
        } else if (basename($_SERVER['PHP_SELF']) == "squad.php") { ?>
            <div class="offcanvas-body h-100 overflow-auto">
                <h5>Members</h5>
                <ul class="list-group list-group-flush offcanvas-body">
                    <?php getMembers($templateParams["members"]); ?>
                </ul>
            </div>
        <?php
        } ?>
    </div>
</aside>