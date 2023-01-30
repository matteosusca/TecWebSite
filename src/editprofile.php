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
                <h5>Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="editprofile.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="formFile" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control bg-body" name="profilePicture" id="profilePicture">
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $user->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="surname" id="surname" value="<?php echo $user->getSurname() ?>">
                        <label for="name">Surname</label>
                    </div>
                    <div class="form-floating">
                        <input type="email" class="form-control bg-body mt-2" name="email" id="email" value="<?php echo $user->getEmail() ?>">
                        <label for="name">Email</label>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    </main>
</body>

</html>