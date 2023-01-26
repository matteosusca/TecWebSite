<?php
if (!empty($_POST['esci'])) {
    session_destroy();
    header("Location: ../signin.php");
}
?>
<header class="navbar navbar-icon-top navbar-expand-lg shadow-sm bg-black navbar-dark ">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">SquadUp
        </a>
        <?php if (isset($_SESSION['username'])) {
            echo '<div class="dropdown order-lg-1">
            <a href="#" class=" link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="' . $dbh->getMediaUrl($dbh->getUser($_SESSION['username'])->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">' . $dbh->getUser($_SESSION['username'])->getUsername() . '</a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow ">
                <li><a class="dropdown-item" href="myprofile.php">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><form action="templates/navbar.php" method="post"><button class="btn dropdown-item" type="submit" value="Accedi" name="esci">Sign out</button></form></li>
            </ul>
        </div>';
        } else {
            echo '<a class="btn btn-outline-light order-lg-1" href="signin.php">Sign in/sign up</a>';
        }
        ?>


        <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
            <ul class="navbar-nav text-center w-100 mx-2 d-flex flex-row flex-wrap justify-content-lg-center justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link <?php isActive("index.php"); ?>" href="index.php"><i class="bi bi-house d-block " style="font-size: 1rem;"></i>Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php isActive("contacts.php"); ?>" href="contacts.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Contacts</a>
                </li>
            </ul>
            <form class="mx-2" role="search">
                <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </div>
</header>