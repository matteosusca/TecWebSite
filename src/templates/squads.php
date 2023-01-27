<h5>Squads</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get squads of user from database and echo them
    $squads = $dbh->getSquadsByUser($_SESSION['username']);
    foreach ($squads as $squad) {
        echo '<a class="list-group-item list-group-item-action" href="squad.php?name=' . $dbh->getSquad($squad)->getName() . '">
        
        <img src="' . $dbh->getMediaUrl($dbh->getSquad($squad)->getPicture()) . '" alt="" width="32" height="32" class="rounded-circle">'

            . $dbh->getSquad($squad)->getName() . '</a>';
    }


    ?>

</ul>