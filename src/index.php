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
            <?php require 'templates/createpost.php';
            require            'templates/posts.php';
            ?>
       
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