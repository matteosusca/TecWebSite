<?php
require_once '../bootstrap.php';
checkSession();
$user = $dbh->getUser($_SESSION['username']);
if (!empty($_POST['esci'])) {
    session_start();
    session_destroy();
    header("Location: ../signin.php");
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>SquadUp</title>
</head>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
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
                        <a class="nav-link <?php isActive("friends.php"); ?>" href="friends.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php isActive("event.php"); ?>" href="event.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Events</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php isActive(" contacts.php"); ?>" href="contacts.php"><i class="bi bi-people d-block" style="font-size: 1rem;"></i>Events</a>
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
    <div class="d-lg-flex flex-wrap vh-100 justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-lg-column text-nowrap">
        </aside>
        <main class="col-12 col-lg-4 p-3 shadow">
        </main>
        <aside class="col-2 p-3 mh-100 shadow overflow-auto sticky-lg-top offcanvas-lg offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        </aside>
    </div>
</body>

</html>