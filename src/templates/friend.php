<h5>Friends</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get friends of user from database and echo them
    $friends = $dbh->getFriends($_SESSION['username']);
    foreach ($friends as $friend) {
        echo '<li class="list-group-item list-group-item-action">' . $dbh->getUser($friend)->getUsername() . '</li>';
    }

    ?>

</ul>