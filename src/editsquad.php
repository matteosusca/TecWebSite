<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}

if (!empty($_POST['save'])) {

    // change squad picture
    if (isset($_FILES['squadPicture']) && is_uploaded_file($_FILES['squadPicture']['tmp_name']) && $_FILES['squadPicture']['error'] == 0) {
        print("Immagine");
        $dbh->setSquadPicture($squad_id, $_FILES['squadPicture']);
    }

    //change name
    if (!empty($_POST['name'])) {
        $dbh->setSquadName($squad_id, $_POST['name']);
    }

    //change description
    if (!empty($_POST['description'])) {
        print("Descrizione");
        $dbh->setSquadDescription($squad_id, $_POST['description']);
    }

    //change permissions for users
    if (!empty($_POST['user']) && !empty($_POST['action'])) {
        switch ($_POST['action']) {
            case 'admin':
                if ($dbh->setUserAdmin($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " made admin");
                } else {
                    print("Unable to make " . $_POST['user'] . " admin");
                }
                break;
            case 'member':
                if ($dbh->setUserMember($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " made member");
                } else {
                    print("Unable to make " . $_POST['user'] . " member");
                }
                break;
            case 'remove':
                if ($dbh->removeUserFromSquad($_POST['user'], $squad_id)) {
                    print($_POST['user'] . " removed");
                } else {
                    print("Unable to remove " . $_POST['user']);
                }
                break;
        }
    }
}

$squad = $dbh->getSquad($squad_id);
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="m-auto">
        <div class="card">
            <div class="card-header">
                <h5>Edit <?php echo $squad->getName() ?> squad</h5>
            </div>
            <div class="card-body">
                <form action="editsquad.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $squad_id; ?>>
                    <div>
                        <label for="formFile" class="form-label">Squad Picture</label>
                        <input type="file" class="form-control bg-body" name="squadPicture" id="formFile">
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $squad->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input name="text" class="form-control bg-body mt-2" name="description" id="description" value="<?php echo $squad->getDescription() ?>">
                        <label for="description">Description</label>
                    </div>
                    <div class="row mx-0">
                        <select name="user" class="col form-select bg-body mt-2  me-2" id="user">
                            <option value="" disabled selected>Seleziona un utente</option>
                            <?php
                            foreach ($squad->getMembers() as $user) {
                                echo "<option value='" . $user . "' >" . $user . "</option>";
                            }
                            ?>
                        </select>
                        <select name="action" class="col form-select bg-body mt-2" id="action">
                            <option value="admin">Make admin</option>
                            <option value="member">Make member</option>
                            <option value="remove">Remove from squad</option>
                        </select>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    </main>
</body>

</html>