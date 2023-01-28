<?php
require_once 'templates/head.php';
checkSession();

if (isset($_GET['user'])) {
    $userProfile = $_GET['user'];
    $userProfile = $dbh->getUser($userProfile);
    if (!$userProfile) {
        $title = "Profile not found";
    } else {
        $title = $userProfile->getUsername() . "'s profile";
    }
    if (isset($_POST['aggiungi'])) {
        $dbh->addFriend($dbh->getUser($_SESSION['username'])->getUsername(), $userProfile->getUsername());
    }
} else {
    $title = "Profile not found";
}

require 'templates/head.php';

?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php require 'templates/navbar.php'; ?>



    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
            <div class="d-flex">
                <img src=<?php echo $dbh->getMediaUrl($userProfile->getProfilePicture()); ?> class="object-fit-contain rounded-circle p-2" alt="..." width="20%" />
                <div class="d-flex flex-column justify-content-evenly">
                    <h5 class="mx-4"><?php echo $userProfile->getUsername() . " (" . $userProfile->getFullName() . "), " . $userProfile->getAge();?></h5>
                </div>
            </div>
            <div class="d-flex flex-lg-column">
                <?php
                if ($userProfile->getUsername() == $_SESSION['username']) {
                    echo '<form action="editprofile.php" method="post">
                    <input type="submit" class="btn btn-outline-secondary border-0" value="Modifica profilo">
                </form>';
                } else {
                    echo '<form action="profile.php?user=' . $userProfile->getUsername() . '" method="post">
                    <input type="hidden" name="aggiungi" value="Aggiungi">
                    <input class="btn btn-outline-secondary border-0" type="submit" value="Aggiungi">
                </form>';
                }
                ?>
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
            
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0"> <?php require 
                'templates/createpost.php';
                                                                                                                                   showPosts($dbh->getUserPosts($userProfile->getUsername())); ?></div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0"> <?php require 'templates/createevent.php';
                                                                                                                             showEvents($dbh->getUserEvents($userProfile->getUsername())); ?></div>
            </div>
        </div>
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto text-nowrap z-1">
        <div class=" h-50 overflow-auto">
            <?php getFriends($dbh,$userProfile->getUsername());?>
            </div>
            <div class=" h-50 overflow-auto">
            <?php getSquads($dbh,$userProfile->getUsername());?>
            </div>
        </aside>
    </main>
</body>

</html>