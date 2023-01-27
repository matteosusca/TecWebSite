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
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-outline-secondary w-100 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                post
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php require 'templates/createpost.php'; ?>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-outline-secondary w-100 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                event
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <?php require 'templates/createevent.php'; ?>
                        </div>
                    </div>
                </div>
            </div>


            <?php require 'templates/post.php'; ?>
        </div>
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <?php require 'templates/members.php'; ?>
        </aside>
    </main>
</body>


</html>