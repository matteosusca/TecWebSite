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
    <title>SquadUp</title>
    <?php require_once 'checkSession.php'; ?>
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
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
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



    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside
            class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto d-flex flex-lg-column text-nowrap z-1">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive"
                aria-controls="offcanvasResponsive">friends</button>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
        </aside>
        <div class="col-12 col-lg-4 p-3 shadow">
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <div class="card-body p-0 mx-auto">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                        class="object-fit-contain" alt="..." height="455" />
                </div>


                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square"></i>
                        commento</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">mostra
                        commenti</button>
                </div>
            </div>
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <div class="card-body p-0 mx-auto">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                        class="object-fit-contain" alt="..." height="455" />
                </div>


                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square"></i>
                        commento</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">mostra
                        commenti</button>
                </div>

            </div>
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <div class="card-body p-0 mx-auto">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                        class="object-fit-contain" alt="..." height="455" />
                </div>


                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square"></i>
                        commento</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">mostra
                        commenti</button>
                </div>

            </div>
        </div>
        <aside class="col-2 p-3 shadow sticky-top mh-100 z-1 overflow-auto offcanvas-lg offcanvas-start" tabindex="-1"
            id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel" data-bs-scroll="true"
            data-bs-backdrop="false">
            <ul class="list-group list-group-flush">
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
                <li class="list-group-item list-group-item-action">An item</li>
                <li class="list-group-item list-group-item-action">A second item</li>
                <li class="list-group-item list-group-item-action">A third item</li>
                <li class="list-group-item list-group-item-action">A fourth item</li>
                <li class="list-group-item list-group-item-action">And a fifth one</li>
            </ul>
        </aside>
    </main>

</body>


</html>