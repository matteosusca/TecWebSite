<?php
require_once 'templates/head.php';
checkSession();

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squadpage.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
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
                    print($_POST['user'] . " made admin");
                } else {
                    print("Unable to remove " . $_POST['user']);
                }
                break;
        }
    }
}

$squad = $dbh->getSquad($squad_id);
?>

<body>
    <div>
        <h1>Edit Squad</h1>
        <form action="editsquad.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value=<?php echo $squad_id; ?>>
            <div>
                <label for="squadPicture">Squad Picture</label>
                <input type="file" name="squadPicture" id="squadPicture">
            </div>
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="<?php echo $squad->getName() ?>">
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" placeholder="<?php echo $squad->getDescription() ?>" rows=4 cols=50></textarea>
            </div>
            <div>
                <label for="user">User</label>
                <select name="user" id="user">
                    <option value="" disabled selected>Seleziona un utente</option>
                    <?php
                    foreach ($squad->getMembers() as $user) {
                        echo "<option value='" . $user . "' >" . $user . "</option>";
                    }
                    ?>
                </select>

                <label for="action">Action</label>
                <select name="action" id="action">
                    <option value="admin">Make admin</option>
                    <option value="member">Make member</option>
                    <option value="remove">Remove from squad</option>
            </div>
            <input type="submit" name="save" value="Save">
        </form>
    </div>
</body>

</html>