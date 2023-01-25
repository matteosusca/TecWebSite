<?php
require_once 'bootstrap.php';
if(isset($_GET['name'])){
    $squad = $_GET['name'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if(!$squadProfile){
        $title = "Squad not found";
        header("Location: squadpage.php?error=1");
    }
    else{
        $title = $squad."'s page";
    }
}
else{
    $title = "Squad not found";
    header("Location: squadpage.php?error=2");
}
?>




<?php require_once 'checkSession.php'; ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $title; ?></title>
</head>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <nav class="navbar navbar-icon-top navbar-expand-lg shadow-sm bg-black navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                <h2> SquadUp </h2>
            </a>
            <div class="dropdown z-2 order-lg-1 ">
                <a href="#" class=" link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle">utente
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow ">
                    <li><a class="dropdown-item" href="signin.php">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
                </ul>
            </div>
            <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
                <ul
                    class="navbar-nav text-center w-100 mx-2 d-flex flex-row justify-content-lg-center justify-content-around">
                    <li class="nav-item">
                        <a class="nav-link active " href="index.php"><i class="bi bi-house d-block "
                                style="font-size: 1rem;"></i>Home</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="#"><i class="bi bi-people d-block"
                                style="font-size: 1rem;"></i>Group</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="contacts.php"><i class="bi bi-people d-block"
                                style="font-size: 1rem;"></i>Contacts</a>
                    </li>

                </ul>

                <form class="mx-2" role="search">
                    <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
                </form>


            </div>


        </div>

    </nav>



    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <aside
            class="col-12 col-lg-3 p-3 shadow sticky-lg-top mh-100 overflow-auto d-flex flex-lg-column text-nowrap z-1">
            
        </aside>
        <div class="col-12 col-lg-5 p-3 shadow">

        </div>
        
    </main>

</body>


</html>











