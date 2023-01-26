<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

if (isset($_GET['name'])) {
    $squad = $_GET['name'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if (!$squadProfile) {
        $title = "Squad not found";
        header("Location: squadpage.php?error=1");
    } else {
        $title = $squad . "'s page";
    }
} else {
    $title = "Squad not found";
    header("Location: squadpage.php?error=2");
}  
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>

    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <aside
            class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <div class="d-flex">
                <img src=<?php echo $dbh->getMediaUrl($squadProfile->getPicture()); ?> class="object-fit-contain rounded-circle p-2" alt="..." width="20%"/>
                <div class="d-flex flex-column justify-content-evenly">
                    <h5 class="mx-4"><?php echo $squadProfile->getName()?></h5>
                    <p class="mx-4"><?php echo $squadProfile->getDescription()?></p>
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
            <?php require 'templates/post.php'; ?>                            
        </div>
            <aside
                class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
                <ul class="list-group list-group-flush offcanvas-body">
                    <?php
                        //get members of the squad and echo them
                        foreach ($squadProfile->getMembers() as $member) {
                            echo '<li class="list-group-item list-group-item-action">' . $$member . '</li>';
                        }
                    ?>
                </ul>
            </aside>
    </main>

</body>


</html>











