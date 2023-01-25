<?php require_once 'bootstrap.php';
require_once 'checkSession.php';
require_once 'templates/head.php'; ?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto d-flex flex-lg-column text-nowrap z-1">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">friends</button>
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
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" class="object-fit-contain" alt="..." height="455" />

                <div class="card-footer d-flex justify-content-around">
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block" style="font-size: 1rem;"></i>
                        mi piace</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>
                        commento</button>
                    <button type="button" class="btn btn-outline-secondary border-0 d-block" style="font-size: 1rem;"><i class="bi bi-shared-block" style="font-size: 1rem;"></i>
                        condividi</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1">mostra
                        commenti</button>
                </div>
            </div>

        </div>
        </div>
        <aside class="col-2 p-3 shadow sticky-top mh-100 z-1 overflow-auto offcanvas-lg offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel" data-bs-scroll="true" data-bs-backdrop="false">
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