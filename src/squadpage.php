<?php
require_once 'bootstrap.php';
if(isset($_GET['name'])){
    $squad = $_GET['name'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if(!$squadProfile){
        $title = "Squad not found";
        header("Location: createsquad.html?error=1");
    }
    else{
        $title = $squad."'s page";
    }
}
else{
    $title = "Squad not found";
    header("Location: createsquad.html?error=2");
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
        <img src=<?php if($squadProfile->getPicture() != null) {
            echo $dbh->getMediaUrl($squadProfile->getPicture());
        } else {
            echo "img/ciccio.jpg";
        } ?> alt="Profile picture">
        <div>
            <h1><?php echo $squadProfile->getId(); ?></h1> <!-- debug purupose -->
            <h2><?php echo $squadProfile->getName(); ?></h2>
            <h3><?php echo $squadProfile->getDescription(); ?></h3>
            <h3><?php echo $squadProfile->getOwner(); ?></h3>
        </div>
    </div>
</body>

</html>