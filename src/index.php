<?php
require_once 'templates/head.php';
require_once 'bootstrap.php';
checkSession();
$user = $dbh->getUser($_SESSION['username']);
?>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div class="d-lg-flex flex-wrap vh-100 justify-content-center overflow-auto">
        <aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-lg-column text-nowrap">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">friends/squads</button>

        </aside>
        <main class="col-12 col-lg-4 p-3 shadow">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <?php require 'templates/createpost.php';
                    foreach ($dbh->getPostOrderByDate($user->getUsername()) as $post) {
                        require 'templates/showpost.php';
                    } ?>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <?php
                    foreach ($dbh->getEventsOrderByDate($user->getUsername()) as $event) {
                        require 'templates/showevent.php';
                    } ?>
                </div>
            </div>
        </main>
        <aside class="col-2 p-3 mh-100 shadow overflow-auto sticky-lg-top">
            <div class="h-100 offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                </div>
                <div class="h-100">
                    <div class=" h-50 overflow-auto">
                        <h5>Friends</h5>
                        <ul class="list-group list-group-flush offcanvas-body">
                            <?php getFriends($dbh->getFriends($user->getUsername())); ?>
                        </ul>
                    </div>
                    <div class=" h-50 overflow-auto">
                        <h5>Squads</h5>
                        <ul class="list-group list-group-flush offcanvas-body">
                            <?php getSquads($dbh->getSquadsByUser($user->getUsername())); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</body>

</html>