<?php
require_once 'templates/head.php';
checkSession();
?>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div class="d-lg-flex flex-wrap vh-100 justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-lg-column text-nowrap">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">friends</button>
            <form class="m-2" role="search">
                <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </aside>
        <main class="col-12 col-lg-4 p-3 shadow">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"> <?php require 'templates/createpost.php';
                                                                                                                                   showPosts($dbh->getPostOrderByDate($_SESSION['username'])) ?></div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0"> <?php require 'templates/createevent.php';
                                                                                                                             showEvents($dbh->getEventsOrderByDate($_SESSION['username'])); ?></div>
            </div>
        </main>
        <aside class="col-2 p-3 mh-100 shadow overflow-auto sticky-lg-top offcanvas-lg offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header  mh-100">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class=" h-50 overflow-auto">
                <?php require_once 'templates/friends.php'; ?>
            </div>
            <div class=" h-50 overflow-auto">
                <?php require_once 'templates/squads.php'; ?>
            </div>
        </aside>
    </div>

</body>


</html>