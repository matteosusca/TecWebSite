<h5>Friends</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get friends of user from database and echo them
    $friends = $dbh->getFriends($_SESSION['username']);
    foreach ($friends as $friend) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user=' . $dbh->getUser($friend)->getUsername() . '">' . $dbh->getUser($friend)->getUsername() . '</a>';
    }

    ?>

</ul>