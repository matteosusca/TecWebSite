<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}

if (!empty($_POST['save'])) {
    if (!empty($_POST['user_friend']) && !empty($_POST['role'])) {
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['user_friend'], $_POST['role'])) {
            print($_POST['user_friend'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['user_friend'] . " to squad");
        }
    } else if (!empty($_POST['searched_user'])  && !empty($_POST['role'])) {
        print("zio canta");
        if ($dbh->addUserToGroup($squad_id, $_SESSION['username'], $_POST['searched_user'], $_POST['role'])) {
            print($_POST['searched_user'] . " added to squad");
        } else {
            print("Unable to add " . $_POST['searched_user'] . " to squad");
        }
    } 
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}
$user = $dbh->getUser($_SESSION['username']);
$squad = $dbh->getSquad($squad_id);
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="m-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add user to <?php echo $squad->getName() ?> group</h5>
            </div>
            <div class="card-body">
                <form action="addusertosquad.php" method="post">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $squad_id; ?>>
                    <div class="row mx-0">
                        <select name="user_friend" class="btn btn-outline-secondary col-12" id="user_friend">
                            <option value="" disabled selected>Seleziona un amico</option>
                            <?php
                            foreach ($user->getFriends() as $friend) {
                                if(!$dbh->isUserMember($friend, $squad_id)) {
                                    echo "<option value='" . $friend . "' >" . $friend . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">Or search for a user</button>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" name="searched_user" id="searched_user" placeholder="User">
                        <label for="floatingInput">User</label>
                    </div>
                    <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">As</button>
                    <select name="role" class="btn btn-outline-secondary col-12 mb-2" id="role" required>
                        <option value="" disabled selected>Seleziona un ruolo</option>
                        <option value="2">admin</option>
                        <option value="3">member</option>
                    </select>
                    <input class="btn btn-outline-secondary w-100" type="submit" name="save" value="Add User"></input>
                </form>
            </div>
        </div>
</body>
</html>