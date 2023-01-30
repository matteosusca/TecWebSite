<?php
if (!empty($_POST['esci'])) {
    session_start();
    session_destroy();
    header("Location: ../signin.php");
}
?>
<nav class="navbar navbar-expand-lg shadow" aria-label="Thirteenth navbar example">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand col-lg-4 m-0 px-2 d-flex justify-content-end" href="index.php">SquadUp</a>

        <?php if (isset($_SESSION['username'])) {
            echo '<div class="dropdown order-lg-1 col-lg-2 d-flex justify-content-start px-2">
            <a href="#" class=" link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="'
                . $dbh->getUser($_SESSION['username'])->getProfilePicture() . '" alt="" width="32" height="32" class="rounded-circle">'
                . $dbh->getUser($_SESSION['username'])->getUsername() . '</a>
            <ul class="dropdown-menu dropdown-menu mx-2 ">
                <li><a class="dropdown-item" href="profile.php?user='
                . $dbh->getUser($_SESSION['username'])->getUsername() . '">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><form action="templates/navbar.php" method="post"><button class="btn dropdown-item" type="submit" value="Accedi" name="esci">Sign out</button></form></li>
            </ul>
        </div>';
        } else {
            echo '<a class="btn btn-outline-light order-lg-1 col-lg-2" href="signin.php">Sign in/sign up</a>';
        }
        ?>

        <div class="collapse navbar-collapse flex-grow-0 col-lg-6" id="navbarsExample11">
            <ul class="navbar-nav col-lg-8 text-center d-flex flex-row justify-content-around">
                <li class="nav-item">
                    <a class="nav-link <?php isActive("index.php"); ?>" href="index.php"><i class="bi bi-house d-block " style="font-size: 1rem;"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php isActive("contacts.php"); ?>" href="contacts.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php isActive("squads.php"); ?>" href="squads.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Squads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php isActive("map.php"); ?>" href="map.php"><i class="bi bi-map d-block" style="font-size: 1rem;"></i>Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php isActive("event.php"); ?>" href="event.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Events</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link <?php isActive(" contacts.php"); ?>" href="contacts.php"><i
                            class="bi bi-people d-block" style="font-size: 1rem;"></i>Events</a>
                </li>
            </ul>
            <div class="col-lg-4">
                <form class="m-2" role="search" action="searchpage.php" method="get">
                    <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search" name="name" onkeydown="if (event.keyCode == 13) { this.form.submit(); }">
                </form>
            </div>
        </div>
    </div>
</nav>