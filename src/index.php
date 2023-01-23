<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SquadUp</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body class="bg-black d-flex flex-column vh-100" data-bs-theme="dark">
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <header class="navbar-brand mx-5">
                <h1> SquadUp </h1>
            </header>
            <div class="collapse navbar-collapse " id="navbarTogglerDemo03">

                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item px-2">
                        <a class="nav-link active " href="#"><i class="bi bi-house d-block"
                                style="font-size: 1.5rem;"></i>Home</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="#"><i class="bi bi-people d-block"
                                style="font-size: 1.5rem;"></i>Group</a>
                    </li>
                </ul>

                <form class="d-flex mx-5" role="search">
                    <input class="form-control me-2 bg-transparent" type="search" placeholder="Search"
                        aria-label="Search">
                </form>
            </div>
        </div>
    </nav>
    <main class="container-fluid overflow-auto d-flex flex-row flex-start flex-wrap vh-100 justify-content-center">
        <div class="m-0 p-2 col-2 p-3 rounded-4 border-4 shadow mh-100 d-none d-sm-block sticky-top">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    Utente
                </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    Amici </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    Compagnie </a>
            </div>
            <footer>
                <p class="font-monospace text-center">
                    Informazioni Assistenza Stampa API Lavora con
                    noi Privacy Condizioni Luoghi Lingua
                    Italiano
                    © 2023 INSTAGRAM FROM META </p>
            </footer>
        </div>
        <div class="m-0 p-2 col-4 p-3 rounded-4 border-4 shadow">
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Crea post </h2>
                </header>
                <section>
                    <form class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Utente</label>
                        <input type="email" class="form-control bg-transparent" id=" exampleFormControlInput1"
                            placeholder="a cosa stai pensando?">
                    </form>
                </section>
                <footer>
                    <form class=" d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0">aggiungi al tuo
                            post</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> foto</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> video</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> altro</button>
                    </form>

                </footer>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
            </article>
            <article class="m-3 p-2 rounded-4 border-4 shadow bg-dark">
                <header>
                    <h2> Utente </h2>
                </header>
                <section>
                    descrizione post
                </section>
                <footer>
                    <form class="d-flex justify-content-around align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-house"></i> mi piace</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-pencil-square"></i> commento</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi bi-share"></i> condividi</button>
                    </form>

                </footer>
            </article>
        </div>
        <div class="m-0 p-2 col-2 p-3 rounded-4 border-4 shadow mh-100 d-none d-sm-block sticky-top">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    amico1
                </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    amico2 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    amico3 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    amico4 </a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-dark bg-transparent border-0">
                    amico5 </a>
            </div>
        </div>
    </main>


</body>
<script>
    $(document).ready(function () {
        $(".navbar-toggler").on("click", function () {
            $(".bi").toggleClass("d-block");
        });
    });

    $(document).ready(function () {
        $(window).on("resize", function () {
            if ($(this).width() < 576) {
                $(".m-0.p-2.col-4.p-3.rounded-4.border-4.shadow").removeClass("col-4");
            }
        });
    });
</script>


</html>