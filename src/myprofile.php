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
                <img src=<?php echo $dbh->getMediaUrl($user->getProfilePicture()); ?> class="object-fit-contain rounded-circle p-2" alt="..." width="20%"/>
                <div class="d-flex flex-column justify-content-evenly">
                    <h5 class="mx-4"><?php echo $user->getUsername()." (".$user->getFullName()."), ".$user->getAge(); ?></h5>
                </div>
            </div>
            <div class="d-flex flex-column">
                <a class="btn btn-secondary m-2" href="" type="button">Amici</a>
                <a class="btn btn-secondary m-2" href="" type="button">Foto</a>                
            </div>
            
        </aside>
        <div class="col-12 col-lg-5 p-3 shadow">
            <?php require 'templates/post.php'; ?>                            
        </div>
    </main>

</body>


</html>