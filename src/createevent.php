<?php
    require_once 'bootstrap.php';
?>
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
</head>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <nav class="navbar navbar-icon-top navbar-expand-lg shadow-sm bg-black navbar-dark ">
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
                    <a class="nav-link  " href="index.php"><i class="bi bi-house d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="#"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Group</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="contacts.php"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Contacts</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="signin.html"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Sign in</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="signup.html"><i class="bi bi-people d-md-inline d-lg-block"
                            style="font-size: 1.5rem;"></i>Sign up</a>
                </li>
            </ul>

            <form class="mx-5" role="search">
                <input class="form-control me-2 bg-body" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </nav>
    <main class="m-auto col-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Crea Evento</h5>
            </div>
            <div class="card-body">
                <form action="createevent.php" method="post" enctype="multipart/form-data">
                    <input type=" text" class="form-control bg-body mb-2" id="name"
                        placeholder="Nome evento" name="name" required>
                    <textarea class="form-control bg-body mb-2" id="description" rows="3"
                        placeholder="Descrizione" name="description" required></textarea>
                    <label for="floatingInput">Data Inizio Evento</label>
                    <input type="date" class="form-control mb-2" id="event_begin_date" name="event_begin_date">
                    <label for="floatingInput">Data Fine Evento</label>
                    <input type="date" class="form-control mb-2" id="event_end_date" name="event_end_date">
                    <label for="floatingInput">Tipo Evento</label>
                    <select class="form-select mb-4" aria-label="Tipo Evento">
                        <?php 
                            foreach($dbh->getEventTypes() as $key => $name) {
                                echo "<option value='".$key."'>".$name."</option>";
                            } 
                        ?>
                    </select>
                    <button class="btn btn-outline-secondary w-100" type="submit" value="Crea"
                        name="submit">Crea</button>
                </form>
            </div>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>


</html>