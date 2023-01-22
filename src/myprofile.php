<?php 
require 'checkSession.php'; 
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Profile</title>
    </head>
    <body>
        <div>
            <?php $user = $dbh->getUser($_SESSION['username']); ?>
            <h1>My Profile</h1>
            <div>
                <img src="<?php echo $dbh->getMediaUrl($user->getProfilePicture()) ?>" alt="Profile Picture" width="200" height="200">
            </div>
            <div>
                <p>Username: <?php echo $user->getUsername() ?></p>
                <p>Full Name: <?php echo $user->getFullName() ?></p>
                <p>Email: <?php echo $user->getEmail() ?></p>
                <p>Age: <?php echo $user->getAge() ?></p>
            </div>
            <div>
                <a href="editprofile.php">Edit Profile</a>
            </div>
        </div>
    </body>