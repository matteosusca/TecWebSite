<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
require 'templates/head.php';
?>

<body class="d-flex flex-column vh-100 vw-100" data-bs-theme="dark">
    <?php
    require_once 'templates/navbar.php'
    ?>
    <div class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside class="col-12 col-lg-2 p-3 shadow sticky-lg-top mh-100 overflow-auto d-flex flex-lg-column text-nowrap">
            <a class="btn btn-secondary m-2" href="createpost.php" type="button">Crea post</a>
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-scroll="true"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                aria-controls="offcanvasWithBothOptions">friends</button>
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
        <main class="col-12 col-lg-4 p-3 shadow">
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                    class="object-fit-contain" alt="..." height="455" />

                <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly" ">
                    <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block"
                        style="font-size: 1rem;"></i>like</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comment</button>
                    <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i
                            class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">comment</button>
                </div>
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
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">Utente</h5>
                    <p class="card-text">descrizione post</p>
                </div>
                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg"
                    class="object-fit-contain" alt="..." height="455" />

                <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly" ">
                    <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block"
                        style="font-size: 1rem;"></i>like</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i
                            class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comment</button>
                    <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i
                            class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target=".multi-collapse" aria-expanded="false"
                        aria-controls="multiCollapseExample1">comment</button>
                </div>
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
        </main>
        <aside class="col-2 p-3 mh-100 z-2  overflow-auto sticky-top offcanvas-lg offcanvas-start" data-bs-scroll="true"
            tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Friends </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <ul class="list-group list-group-flush offcanvas-body">
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
    </div>

</body>


</html>