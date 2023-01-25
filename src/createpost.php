<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
require_once 'templates/head.php';

//getuser
$user = $dbh->getUser($_SESSION['username']);
if (!empty($_POST['submit'])) {
    $dbh->createPost($_SESSION['username'], $_POST['description'], $_FILES['postfile']);
}

?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php require_once 'templates/navbar.php'; ?>
    <main class="m-auto col-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"> Crea post</h5>
            </div>
            <div class="card-body">
                <form action="createpost.php" method="post" enctype="multipart/form-data">
                    <input type=" text" class="form-control bg-body" id="description" placeholder="a cosa stai pensando?" name="description" required>
                    <button type="button" class="btn btn-outline-secondary border-0 disabled">aggiungi al tuo
                        post</button>
                    <input type="file" name="postfile" id="postfile" class="btn btn-outline-secondary border-0" required></input>
                    <button class="btn btn-outline-secondary w-100" type="submit" value="Pubblica" name="submit">Pubblica</button>
                </form>
            </div>
        </div>
    </main>
</body>


</html>