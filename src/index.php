<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
require 'templates/head.php';
?>

<body class="d-flex flex-column vh-100 vw-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto d-flex flex-lg-column text-nowrap">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">friends</button>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
        </aside>
        <main class="col-12 col-lg-4 p-3 shadow">
            <?php require 'templates/post.php'; ?>
            <?php require 'templates/post.php'; ?>
            <?php require 'templates/post.php'; ?>
        </main>
        <aside class="col-2 p-3 mh-100 z-2  overflow-auto sticky-top offcanvas-lg offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Friends </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <?php require_once 'templates/friend.php'; ?>
        </aside>
    </div>

</body>


</html>