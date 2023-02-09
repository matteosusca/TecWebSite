<?php
require_once 'utils/functions.php';
if (checkSession()) {
    $user = $dbh->getUser($_SESSION['username']);
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $templateParams["title"] ?></title>
</head>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <nav class="navbar navbar-expand-lg shadow" aria-label="navbar">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand col-lg-4 m-0 px-2 d-flex justify-content-end" href="index.php">SquadUp</a>
            <?php if (isset($_SESSION['username'])) { ?>
                <div class="dropdown order-lg-1 col-lg-2 d-flex justify-content-start px-2">
                    <a href="#" class=" link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $user->getProfilePicture() ?>" alt="<?php echo $user->getUsername() ?> profile picture" width="32" height="32" class="rounded-circle">
                        <?php echo $user->getUsername() ?></a>
                    <ul class="dropdown-menu dropdown-menu mx-2 ">
                        <li><a class="dropdown-item" href="profile.php?user=<?php echo $user->getUsername() ?>">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="signin.php" method="post"><button class="btn dropdown-item" type="submit" value="Sign Out" name="esci">Sign out</button></form>
                        </li>
                    </ul>
                    <button class="btn btn-secondary position-relative mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><em class="bi bi-bell d-block"></em>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">22+</span>
                </button>
                </div> <?php
                    } else { ?>
                <a class="btn btn-outline-light order-lg-1 col-lg-2" href="signin.php">Sign in/sign up</a>
            <?php
                    }
            ?>

            <div class="collapse navbar-collapse flex-grow-0 col-lg-6" id="navbarHeader">
                <ul class="navbar-nav col-lg-8 text-center d-flex flex-row justify-content-around">
                    <li class="nav-item">
                        <a class="nav-link <?php isActive("index.php"); ?>" href="index.php"><em class="bi bi-house d-block"></em>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php isActive("contacts.php"); ?>" href="contacts.php"><em class="bi bi-people d-block"></em>Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php isActive("map.php"); ?>" href="map.php"><em class="bi bi-map d-block"></em>Map</a>
                    </li>
                </ul>
                <div class="col-lg-4">
                    <form class="m-2" role="search" action="search.php" method="get">
                        <label class="visually-hidden" for="search-bar">Search</label>
                        <input type="search" class="form-control bg-body" id="search-bar" placeholder="Search" name="name" onkeydown="if (event.keyCode == 13) { this.form.submit(); }">
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-label="Notifications">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Notifications</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>first notify</p>
        </div>
    </div>
    <?php if (isset($templateParams["body"])) {
        require $templateParams["body"];
    } else { ?>
        <div class="d-lg-flex flex-wrap vh-100 justify-content-center overflow-auto">
            <?php if (isset($templateParams["left-aside"])) {
                require $templateParams["left-aside"];
            }
            if (isset($templateParams["main"])) {
                require $templateParams["main"];
            }
            if (isset($templateParams["right-aside"])) {
                require $templateParams["right-aside"];
            } ?>
        </div>
    <?php } ?>
    <?php if (isset($templateParams["js"])) :
        foreach ($templateParams["js"] as $script) : ?>
            <script src="<?php echo $script; ?>"></script>
    <?php endforeach;
    endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="js/set_active_user.js"></script>
</body>


</html>