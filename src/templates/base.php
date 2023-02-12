<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $templateParams["title"] ?></title>
</head>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <nav class="navbar navbar-expand-lg shadow">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand col-lg-4 m-0 px-2 d-flex justify-content-end" href="index.php"><h1>SquadUp</h1></a>
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
                        <span id="notification_counter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
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

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" >
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Notifications</h5>
            <label class="visually-hidden" for="closebtn">Close</label>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" id="closebtn"></button>
        </div>
        <div id="notifications" class="list-group list-group-flush offcanvas-body">          
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
    <?php } 
    require_once("modal.php");
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/axios.min.js"></script>
    <?php if (isset($templateParams["js"])) :
        foreach ($templateParams["js"] as $script) : ?>
            <script src="<?php echo $script; ?>"></script>
    <?php endforeach;
    endif; ?>
    <script src="js/localization.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize"></script>
    <script src="js/set_active_user.js"></script>
    <script src="js/get_notification.js"></script>
    <script src="js/accept.js"></script>
    <script src="js/decline.js"></script>
    
</body>


</html>