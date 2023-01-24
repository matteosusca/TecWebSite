<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>SquadUp</title>
    <?php require_once 'checkSession.php'; ?>
</head>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <nav class="navbar navbar-icon-top navbar-expand-lg shadow-sm bg-black navbar-dark ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <header class="navbar-brand mx-5">
            <h2> SquadUp </h2>
        </header>
        <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item">
                    <a class="nav-link active " href="index.php"><i class="bi bi-house d-md-inline d-lg-block"
                            style="font-size: 1rem;"></i>Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="#"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1rem;"></i>Group</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="contacts.html"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1rem;"></i>Contacts</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="signin.html"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1rem;"></i>Sign in</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="signup.html"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1rem;"></i>Sign up</a>
                </li>
            </ul>

            <form class="mx-5" role="search">
                <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </nav>
    <main class=" container-fluid overflow-auto d-flex flex-row flex-start flex-wrap justify-content-center vh-100">
        <aside class="col-2 p-3 shadow mh-100 d-none d-lg-block sticky-top">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item border-0">
                    Utente
                </a>
            </div>
            <footer class="bottom-0 position-absolute"> © 2023 INSTAGRAM FROM META
            </footer>
        </aside>
        <div class="col-12 col-lg-4 p-3 shadow">
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title"> Crea post</h5>
                </div>
                <div class="card-body">
                    <form class="mb-3">
                        <input type="email" class="form-control bg-body" id=" exampleFormControlInput1"
                            placeholder="a cosa stai pensando?">
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 disabled">aggiungi al tuo
                        post</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        foto</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square"></i> video</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        altro</button>
                </div>
            </div>
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title"> Utente</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">descrizione post</p>
                </div>
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                    class="object-fit-contain" alt="..." height="455" />

                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square"></i> commento</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                    <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">mostra
                        commenti</button>
                </div>
                <form role="commento">
                    <input class="form-control bg-body" type="commento" placeholder="commento" aria-label="commento">
                </form>
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <div class="card m-2">
                        <div class="card-header">
                            <p class="card-text">Utente</p>
                        </div>
                        <div class="card card-body">
                            <p class="card-text">commento</p>
                        </div>
                    </div>
                    <div class="card m-2">
                        <div class="card-header">
                            <p class="card-text">Utente</p>
                        </div>
                        <div class="card card-body">
                            <p class="card-text">commento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <aside class="col-2 p-3 shadow mh-100 d-none d-lg-block sticky-top">
            <div cla ss="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item border-0">
                    amico1
                </a>
            </div>
        </aside>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>


</html>