<h5>Squads</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get squads of user from database and echo them
    $squads = $dbh->getSquadsByUser($_SESSION['username']);
    foreach ($squads as $squad) {
        echo '<li class="list-group-item list-group-item-action">' . $dbh->getSquad($squad)->getName() . '</li>';
    }


    ?>

</ul>