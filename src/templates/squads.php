<h5>Squads</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get squads of user from database and echo them
    $squads = $dbh->getSquadsByUser($_SESSION['username']);
    foreach ($squads as $squad) {
        echo '<a class="list-group-item list-group-item-action" href="squadpage.php?name=' . $dbh->getSquad($squad)->getName() . '">' . $dbh->getSquad($squad)->getName() . '</a>';
    }


    ?>

</ul>