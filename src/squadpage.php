<?php
require_once 'bootstrap.php';
if(isset($_GET['squad'])){
    $squad = $_GET['squad'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if(!$squadProfile){
        $title = "Squad not found";
    }
    else{
        $title = $Squad."'s page";
    }
}
else{
    $title = "Squad not found";
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
        <img src=<?php echo $dbh->getMediaUrl($squadProfile->getPicture()); ?> alt="Profile picture">
        <div>
            <h1><?php echo $squadProfile->getId(); ?></h1> //debug purupose
            <h2><?php echo $squadProfile->getName(); ?></h2>
            <h3><?php echo $squadProfile->getDescription(); ?></h3>
            <h3><?php echo $squadProfile->getOwner(); ?></h3>
        </div>
    </div>
</body>

</html>