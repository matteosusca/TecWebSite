<?php
require_once 'templates/head.php';
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
        header('Location: profile.php?user=' .  $userProfile->getUsername());
    }
} else {
    $title = "Profile not found";
}

?>

<body>
    <div>
        <img src=<?php echo $dbh->getMediaUrl($userProfile->getProfilePicture()); ?> alt="Profile picture">
        <div>
            <h1><?php echo $userProfile->getFullName(); ?></h1>
            <h2><?php echo $userProfile->getAge(); ?></h2>
        </div>
        <form action="profile.php?user=<?php echo $userProfile->getUsername(); ?>" method="post"><button class="btn dropdown-item" type="submit" value="Accedi" name="aggiungi">aggiungi</button></form>
    </div>
</body>

</html>