<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();
if (isset($_GET['name'])) {
    $squad = $_GET['name'];
    $squadProfile = $dbh->getSquads($squad)[0];
    if (!$squadProfile) {
        $title = "Squad not found";
        header("Location: squadpage.php?error=1");
    } else {
        $title = $squad . "'s page";
    }
} else {
    $title = "Squad not found";
    header("Location: squadpage.php?error=2");
}
    
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div>
        <img src=<?php if ($squadProfile->getPicture() != null) {
                        echo $dbh->getMediaUrl($squadProfile->getPicture());
                    } else {
                        echo "img/ciccio.jpg";
                    } ?> alt="Profile picture">
        <div>
            <h1><?php echo $squadProfile->getId(); ?></h1> <!-- debug purupose -->
            <h2><?php echo $squadProfile->getName(); ?></h2>
            <h3><?php echo $squadProfile->getDescription(); ?></h3>
            <h3><?php echo $squadProfile->getOwner(); ?></h3>
            <h3>
                <ul><?php
                    foreach ($squadProfile->getMembers() as $member) {
                        echo "<li>" . $member . "</li>";
                    }
                    ?></ul>
            </h3>
        </div>
        <div>
            <h2>
                <form action="editsquad.php" method="post">
                    <input type="hidden" name="id" value=<?php echo $squadProfile->getId(); ?>>
                    <input type="submit" name="edit_squad" value="Edit Squad">
                </form>
            </h2>
        </div>
    </div>
</body>

</html>