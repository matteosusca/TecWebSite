<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

if (isset($_GET['name'])) {
    $squad = $_GET['name'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if (!$squadProfile) {
        $title = "Squad not found";
        header("Location: squad.php?error=1");
    } else {
        $title = $squad . "'s page";
    }
} else {
    $title = "Squad not found";
    header("Location: squad.php?error=2");
}
if (!empty($_POST['submit'])) {
    $dbh->createEvent($squadProfile->getID(), $_POST['name'], $_POST['description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $_SESSION['username']);
}
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <div class="d-flex">
                <img src=<?php echo $dbh->getMediaUrl($squadProfile->getPicture()); ?> class="object-fit-contain rounded-circle p-2" alt="..." width="20%" />
                <div class="d-flex flex-column justify-content-evenly">
                    <h5 class="mx-4"><?php echo $squadProfile->getName() ?></h5>
                    <p class="mx-4"><?php echo $squadProfile->getDescription() ?></p>
                </div>
            </div>
            <div class="d-flex flex-lg-column">
                <form action="editsquad.php" method="post">
                    <input type="hidden" name="id" value=<?php echo $squadProfile->getId(); ?>>
                    <input class="btn btn-outline-secondary border-0" type="submit" name="edit_squad" value="Edit Squad">
                </form>
            </div>
        </aside>

        <div class="col-12 col-lg-4 p-3 shadow mh-100">
        <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"> <?php require 'templates/createpost.php';
                                                                                                                                   showPosts($dbh->getSquadPosts($squadProfile->getID())) ?></div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0"> <?php require 'templates/createevent.php';
                                                                                                                             showEvents($dbh->getSquadEvents($squadProfile->getID())); ?></div>
            </div>
        </div>
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <?php require 'templates/members.php'; ?>
        </aside>
    </main>
</body>


</html>