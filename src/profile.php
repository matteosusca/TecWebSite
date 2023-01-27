<?php
require_once 'templates/head.php';
checkSession();

if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $userProfile = $dbh->getUser($user);
    if (!$userProfile) {
        $title = "Profile not found";
    } else {
        $title = $user . "'s profile";
    }
    if (isset($_POST['aggiungi'])) {
        $dbh->addFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    }
} else {
    $title = "Profile not found";
}

$user = $dbh->getUser($_SESSION['username']);

require 'templates/head.php';

?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php require 'templates/navbar.php'; ?>

    

    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <div class="d-flex">
                <img src=<?php echo $dbh->getMediaUrl($user->getProfilePicture()); ?> class="object-fit-contain rounded-circle p-2" alt="..." width="20%" />
                <div class="d-flex flex-column justify-content-evenly">
                    <h5 class="mx-4"><?php echo $user->getUsername() . " (" . $user->getFullName() . "), " . $user->getAge(); ?></h5>
                </div>
            </div>
            <div class="d-flex flex-lg-column">
                <form action="" method="post">
                    <input type="hidden" name="aggiungi" value="Aggiungi">
                    <input class="btn btn-outline-secondary border-0" type="submit" value="Aggiungi">
                </form>
            </div>
        </aside>

        <div class="col-12 col-lg-4 p-3 shadow mh-100">
            <?php
                foreach($dbh->getUsersPosts($user->getUsername()) as $post){
                    echo $post->showPost();
                }
            ?>
        </div>
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <?php require 'templates/friends.php'; ?>
        </aside>
    </main>
</body>

</html>