<?php 
require_once 'bootstrap.php';
require_once 'checkSession.php';
$user = $dbh->getUser($_SESSION['username']);

require 'templates/head.php';

?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php require 'templates/navbar.php'; ?>

    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto ">
        <aside
            class="col-12 col-lg-3 p-3 shadow sticky-lg-top mh-100 m-0 overflow-auto  text-nowrap z-1 container-fluid">
            <div class="d-flex">
                <img src=<?php echo $dbh->getMediaUrl($user->getProfilePicture()); ?> class="object-fit-contain" alt="..." width="20%"/>
                <div class="d-flex flex-column justify-content-evenly">
                    <p class="mx-4">12 Stronzi</p>
                    <p class="mx-4">17 Foto di merda</p>
                </div>
            </div>
            <div class="d-flex flex-column">
                <p class="mx-4"><?php echo $user->getUsername()." (".$user->getFullName()."), ".$user->getAge(); ?></p>
            </div>
            
        </aside>
        <div class="col-12 col-lg-5 p-3 shadow">
            <div class="card m-2">
                <div class="card-header">
                    <?php echo "<h3>".$user->getUsername()."</h3>"; ?>
                    <?php echo "<h5>".$user->getFullName().", ".$user->getAge()."</h5>"; ?>
                </div>
                <img src=<?php echo $dbh->getMediaUrl($user->getProfilePicture()); ?>
                        class="object-fit-contain" alt="..."/>
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
    </main>

</body>


</html>