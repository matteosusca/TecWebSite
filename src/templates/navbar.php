<?php
if (!empty($_POST['esci'])) {
    session_destroy();
    header("Location: ../signin.php");
}
?>
<nav class="navbar navbar-expand-lg shadow" aria-label="Thirteenth navbar example">
    <div class="container-fluid p-0">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11"
            aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand col-lg-2 m-0 px-2 d-lg-flex justify-content-lg-end" href="#">SquadUp</a>
        <div class="col-lg-2"></div>
        <?php if (isset($_SESSION['username'])) {
            echo '<div class="d-lg-flex  dropdown order-lg-1 col-lg-2 justify-content-lg-start m-0 px-2">
            <a href="#" class=" link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="' . $dbh->getMediaUrl($dbh->getUser($_SESSION['username'])->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">' . $dbh->getUser($_SESSION['username'])->getUsername() . '</a>
            <ul class="dropdown-menu dropdown-menu-end shadow ">
                <li><a class="dropdown-item" href="myprofile.php">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><form action="templates/navbar.php" method="post"><button class="btn dropdown-item" type="submit" value="Accedi" name="esci">Sign out</button></form></li>
            </ul>
        </div>';
        } else {
            echo '<a class="btn btn-outline-light order-lg-1 col-lg-1" href="signin.php">Sign in/sign up</a>';
        }
        ?>

        <div class="collapse navbar-collapse" id="navbarsExample11">
            <ul
                class="navbar-nav col-lg-8 d-flex flex-row justify-content-around justify-content-lg-center text-center">
                <li class="nav-item">
                    <a class="nav-link <?php isActive(" index.php"); ?>" href="index.php"><i
                            class="bi bi-house d-block " style="font-size: 1rem;"></i>Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php isActive(" contacts.php"); ?>" href="contacts.php"><i
                            class="bi bi-people d-block" style="font-size: 1rem;"></i>Contacts</a>
                </li>
            </ul>
            <form class="col-lg-4" role="search">
                <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </div>
</nav>