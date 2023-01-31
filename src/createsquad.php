<?php
require_once 'templates/head.php';
checkSession();

if (!empty($_POST['save'])) {
    $squad_id = $dbh->createSquad($_POST['name'], $_POST['description'], $_FILES['squadPicture'], $_SESSION['username']);
    header("Location: squad.php?squad_id=" . $squad_id);
}

?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="m-auto">
        <div class="card">
            <div class="card-header">
                <h5>Create new squad</h5>
            </div>
            <div class="card-body">
                <form action="createsquad.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="name" placeholder="Nome squad" name="name" required>
                        <label for="name">Nome squad</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control bg-body mt-2" id="description" name="description" placeholder="Descrizione" required></textarea>    
                        <label for="description">Descrizione</label>
                    </div>
                    <div>
                        <label for="formFile" class="form-label">Squad Picture</label>
                        <input type="file" class="form-control bg-body" name="squadPicture" id="squadPicture" required>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    </main>
</body>

</html>