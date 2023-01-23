<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
    </head>
    <body>
        <div>
            <?php $user = $dbh->getUser($_SESSION['username']); ?>
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
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" placeholder="<?php echo $user->getAge() ?>">
                </div>
                <div>
                    <input type="submit" value="Save">
                </div>
            </form>
        </div>
<?php
print("Daje fra");
//check if file is uploaded
if(isset($_FILES['profilePicture'])){
    $dbh->setProfilePicture($_SESSION['username'], $_FILES['profilePicture']);
}
?>
    </body>
</html>