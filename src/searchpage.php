<?php
require_once 'bootstrap.php';
if(isset($_GET['name'])){
    $name = $_GET['name'];
    $user = $dbh->getUser($name);
    $squads = $dbh->getSquads($name);
    $userCreatedSquads = $dbh->getSquadsCreatedByUser($name);
    if(!$user && !$squads && !$userCreatedSquads){ 
        $title = "Nothing to show here";
        header("Location: searchpage.php?error=1");
    }
    else{
        $title = "Results for " . $name;
    }
}
else{
    $title = "Nothing to show here";
    header("Location: searchpage.php?error=2");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <div>
            <h1><?php echo $user->getUsername(); ?></h1>
            <h2><?php echo $user->getName(); ?></h2>
            <h2><?php echo $user->getSurname(); ?></h2>
            <img src=<?php if($user->getProfilePicture() != null) {
                echo $dbh->getMediaUrl($user->getProfilePicture());
            } else {
                echo "img/ciccio.jpg";
            } ?> alt="Profile picture">
        </div>

        <?php 
            if(!is_null($squads)) {
                foreach($squads as $squad) {
                    echo "<div>";
                    echo "<h1>".$squad->getName()."</h1>";
                    echo "<h2>".$squad->getDescription()."</h2>";
                    echo "<h3>".$squad->getOwner()."</h3>";
                    echo "<img src=img/ciccio.jpg alt='Profile picture'>";
                    echo "</div>";
                }
            }
        ?>
        
        <?php 
            if(!is_null($userCreatedSquads)) {
                foreach($userCreatedSquads as $squad) {
                    echo "<div>";
                    echo "<h1>".$squad->getName()."</h1>";
                    echo "<h2>".$squad->getDescription()."</h2>";
                    echo "<h3>".$squad->getOwner()."</h3>";
                    echo "<img src=img/ciccio.jpg alt='Profile picture'>";
                    echo "</div>";
                }
            }
       ?>
    <div>
</body>

</html>