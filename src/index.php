<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SquadUp</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">

    <nav class="navbar navbar-icon-top navbar-expand-lg shadow-sm">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <header class="navbar-brand mx-5">
            <h1> SquadUp </h1>
        </header>
        <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item px-2">
                    <a class="nav-link active " href="#"><i class="bi bi-house d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="#"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Group</a>
                </li>
            </ul>

            <form class="mx-5" role="search">
                <input class="form-control me-2 bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </nav>
    <main class=" container-fluid overflow-auto d-flex flex-row flex-start flex-wrap justify-content-center">
        <aside class="m-0 col-2 p-3 shadow mh-100 d-none d-lg-block sticky-top">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item ">
                    Utente
                </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item  ">
                    Amici </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item ">
                    Compagnie </a>
            </div>
            <footer>
                <p class="font-monospace text-center">
                    Informazioni Assistenza Stampa API Lavora con
                    noi Privacy Condizioni Luoghi Lingua
                    Italiano
                    © 2023 INSTAGRAM FROM META </p>
            </footer>
        </aside>
        <div class="m-0  col-12 col-lg-4 p-3 shadow">
            <div class="card m-2">
                <div class="card-body">
                    <h5 class="card-title"> Crea post</h5>
                    <p class="card-text">
                    <form class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Utente</label>
                        <input type="email" class="form-control bg-body" id=" exampleFormControlInput1"
                            placeholder="a cosa stai pensando?">
                    </form>
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0">aggiungi al tuo
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
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                    class="object-fit-contain" alt="..." height="455" />
                <div class="card-body">
                    <h5 class="card-title"> Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square"></i> commento</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                </div>
            </div>
            <div class="card m-2">
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                    class="object-fit-contain" alt="..." height="455">
                <div class="card-body">
                    <h5 class="card-title"> Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <div class="card-footer d-flex justify-content-around align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-house"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square"></i> commento</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i class="bi bi-share"></i>
                        condividi</button>
                </div>
            </div>
        </div>
        <aside class="m-0 col-2 p-3 shadow mh-100 d-none d-lg-block sticky-top">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item">
                    amico1
                </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item ">
                    amico2 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item ">
                    amico3 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item">
                    amico4 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item">
                    amico5 </a>
            </div>
        </aside>
    </main>

</body>


</html>