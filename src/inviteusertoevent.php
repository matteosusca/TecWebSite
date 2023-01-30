<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

$squad_id = $_POST['id'];
if (!$dbh->checkUserPermissionsForSquad($_SESSION['username'], $squad_id)) {
    header("Location: squad.php?name=" . $dbh->getSquad($squad_id)->getName() . "");
}

if (!empty($_POST['invita'])) {
    $dbh->inviteUserToEvent($_POST['event'], $squad_id, $_POST['user'] );
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
                <form action="inviteusertoevent.php" method="post">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $squad_id; ?>>
                    <select name="event" class="col form-select bg-body" id="event">
                        <option value="" disabled selected>evento</option>
                        <?php
                        foreach ($dbh->getSquadEvents($squad->getID()) as $event) {
                            echo "<option value='" . $event->getIdEvent() . "' >" . $event->getName() . "</option>";
                        }
                        ?>
                    </select>
                    <select name="user" class="col mt-2 form-select bg-body" id="user">
                        <option value="" disabled selected>utente</option>
                        <?php
                        foreach ($squad->getMembers() as $user) {
                            echo "<option value='" . $user . "' >" . $user . "</option>";
                        }
                        ?>
                    </select>
                    <input class="btn btn-outline-secondary mt-3 w-100" type="submit" name="invita" value="Invite User"></input>
                </form>
            </div>
        </div>
</body>

</html>