<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
//check if file is uploaded
if(isset($_FILES['profilePicture']) && is_uploaded_file($_FILES['profilePicture']['tmp_name']) && $_FILES['profilePicture']['error'] == 0){
    print("Immagine");
    $dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture']);
}
if(!empty($_POST['name'])){
    print("Nome");
    $dbh->setName($_SESSION['username'], $_POST['name']);
}
if(!empty($_POST['surname'])){
    print("Cognome");
    $dbh->setSurname($_SESSION['username'], $_POST['surname']);
}
if(!empty($_POST['email'])){
    print("Email");
    if(!$dbh->setMail($_SESSION['username'], $_POST['email'])){
        header("Location: editprofile.php?error=1");
    }
    
}

$user = $dbh->getUser($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
    </head>
    <body>
        <div>
            <?php if(isset($_GET['error']) && $_GET['error'] == 1){ ?>
                <p>Mail already in use</p>
            <?php } ?>
            <h1>Edit Profile</h1>
            <form action="editprofile.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="profilePicture">Profile Picture</label>
                    <input type="file" name="profilePicture" id="profilePicture">
                </div>
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="<?php echo $user->getName() ?>">
                </div>
                <div>
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" id="surname" placeholder="<?php echo $user->getSurname() ?>">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="<?php echo $user->getEmail() ?>">
                </div>
                <div>
                    <input type="submit" value="Save">
                </div>
            </form>
        </div>
    </body>
</html>