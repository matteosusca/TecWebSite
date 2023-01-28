<?php
require_once 'templates/head.php';
checkSession();
//check if file is uploaded
if (isset($_FILES['profilePicture']) && is_uploaded_file($_FILES['profilePicture']['tmp_name']) && $_FILES['profilePicture']['error'] == 0) {
    $dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture']);
}
if (!empty($_POST['name'])) {
    $dbh->setName($_SESSION['username'], $_POST['name']);
}
if (!empty($_POST['surname'])) {
    $dbh->setSurname($_SESSION['username'], $_POST['surname']);
}
if (!empty($_POST['email'])) {
    if (!$dbh->setMail($_SESSION['username'], $_POST['email'])) {
        header("Location: editprofile.php?error=1");
    }
}

$user = $dbh->getUser($_SESSION['username']);
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="m-auto">
        <div class="card">
            <?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                <p>Mail already in use</p>
            <?php } ?>
            <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="editprofile.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <button type="button" class="btn btn-outline-secondary border-0 disabled">Profile Picture</button>
                        <input type="file" class="btn btn-outline-secondary" name="profilePicture" id="profilePicture">
                    </div>
                    <div class="form-floating">
                        <!-- placeholder not working -->
                        <input type="text" class="form-control bg-body" name="name" id="name" placeholder="<?php echo $user->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <!-- placeholder not working -->
                        <input type="text" class="form-control bg-body" name="surname" id="surname" placeholder="<?php echo $user->getSurname() ?>">
                        <label for="name">Surname</label>
                    </div>
                    <div class="form-floating">
                        <!-- placeholder not working -->
                        <input type="email" class="form-control bg-body" name="email" id="email" placeholder="<?php echo $user->getEmail() ?>">
                        <label for="name">Email</label>
                    </div>
                    <input class="btn btn-outline-secondary w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    </main>
</body>

</html>