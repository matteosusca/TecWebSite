<?php

require_once 'bootstrap.php';
require_once 'templates/head.php';
checkSession();

if(isset($_GET['name'])){
    $name = $_GET['name'];
    $user = $dbh->getUser($name);
    $squads = $dbh->getSquads($name);
    $title = "Results for " . $name;
} else{
    $title = "Nothing to show here";
    header("Location: searchpage.php?error=2");
}
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <main class="d-lg-flex flex-wrap justify-content-center overflow-auto vh-100">
        <div class="col-12 col-lg-4 p-3 shadow mh-100">    
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="true">User</button>
                    <button class="nav-link" id="nav-squads-tab" data-bs-toggle="tab" data-bs-target="#nav-squads" type="button" role="tab" aria-controls="nav-squads" aria-selected="false">Squads</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab" tabindex="0"> 
                    <?php 
                        if(!is_null($user)) {
                            echo $user->showUser();
                        } else {
                            echo "<div class='alert alert-danger col-6' role='alert'>";
                            echo "No user found";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="tab-pane fade" id="nav-squads" role="tabpanel" aria-labelledby="nav-squads-tab" tabindex="0">
                    <?php 
                        if(!empty($squads)) {
                            foreach($squads as $squad) {
                                echo $squad->showSquad();
                            }
                        } else {
                            echo "<div class='alert alert-danger col-6' role='alert'>";
                            echo "No squads found";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>