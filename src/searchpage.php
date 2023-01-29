<?php

require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $user = $dbh->getUser($name);
    $squads = $dbh->getSquads($name);
    if(!$user && !$squads){ 
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

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="true">User</button>
            <button class="nav-link" id="nav-squads-tab" data-bs-toggle="tab" data-bs-target="#nav-squads" type="button" role="tab" aria-controls="nav-squads" aria-selected="false">Squads</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab" tabindex="0"> 
            <div>
                <?php 
                    if(!is_null($user)) {
                        echo "<div>";
                        echo "<h1>".$user->getUsername()."</h1>";
                        echo "<h2>".$user->getFullName()."</h2>";
                        echo "<img src=" . $dbh->getMediaUrl($user->getProfilePicture()) . "alt='Profile picture'>";
                        echo "</div>";
                    }
                    ?>
            <div>
                <div class="tab-pane fade" id="nav-squads" role="tabpanel" aria-labelledby="nav-squads-tab" tabindex="0">
                    <div>
                    <?php 
                    var_dump($squads);
                    if(!is_null($squads)) {
                        foreach($squads as $squad) {
                            echo "<div>";
                            echo "<h1>".$squad->getName()."</h1>";
                            echo "<h2>".$squad->getDescription()."</h2>";
                            echo "<h3>".$squad->getOwner()."</h3>";
                            echo "<img src=" . $dbh->getMediaUrl($squad->getImage()) . "alt='Profile picture'>";
                            echo "</div>";
                        }
                    }
                ?>
            <div>
        </div>
</body>

</html>