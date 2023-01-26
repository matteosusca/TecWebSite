<?php
require_once 'templates/head.php';
checkSession();
$user = $dbh->getUser($_SESSION['username']);
if (!empty($_POST['submit'])) {
    $dbh->createPost($_SESSION['username'], $_POST['description'], $_FILES['postfile']);
}
?>

<body class="d-flex flex-column vh-100 vw-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-lg-column text-nowrap">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">friends</button>
        </aside>
        <main class="col-12 col-lg-4 p-3 shadow">
            <?php require 'templates/createpost.php'; ?>
            <?php require 'templates/post.php'; ?>
            <?php require 'templates/post.php'; ?>
            <?php require 'templates/post.php'; ?>
        </main>
        <aside class="col-2 p-3 z-2 mh-100 shadow overflow-auto sticky-top offcanvas-lg offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header  mh-100">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Friends </h5>
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