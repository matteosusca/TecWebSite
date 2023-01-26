<?php
require_once 'bootstrap.php';
checkSession();

$squad_id = $_POST['id'];
if(!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)){
    header("Location: squadpage.php?name=".$dbh->getSquad($squad_id)->getName()."");
}
 
if(!empty($_POST['save'])){

    // change squad picture
    if(isset($_FILES['squadPicture']) && is_uploaded_file($_FILES['squadPicture']['tmp_name']) && $_FILES['squadPicture']['error'] == 0){
        print("Immagine");
        $dbh->setSquadPicture($squad_id, $_FILES['squadPicture']);
    }

    //change name
    if(!empty($_POST['name'])){
        $dbh->setSquadName($squad_id, $_POST['name']);
    }

    //change description
    if(!empty($_POST['description'])){
        print("Descrizione");
        $dbh->setSquadDescription($squad_id, $_POST['description']);
    }

    //change permissions for users
    if(!empty($_POST['user']) && !empty($_POST['action'])) {
        switch($_POST['action']) {
            case 'admin':
                print("User reso admin");
                $dbh->setUserAdmin($_POST['user'], $squad_id);
                break;
            case 'member':
                print("User reso membro");
                $dbh->setUserMember($_POST['user'], $squad_id);
                break;
            case 'remove':
                print("User rimosso");
                $dbh->removeUserFromSquad($_POST['user'], $squad_id);
                break;
        }
    }
}

$squad = $dbh->getSquad($squad_id);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
    </head>
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
                    <textarea name="description" rows = 4 cols=50"><?php echo $squad->getDescription() ?></textarea>
                </div>
                <div>
                    <label for="user">User</label>
                    <select name="user" id="user">
                        <option value="" disabled selected>Seleziona un utente</option>
                        <?php
                        foreach($squad->getMembers() as $user) {
                            echo "<option value='".$user."' >".$user."</option>";
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

