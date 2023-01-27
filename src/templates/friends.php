<h5>Friends</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get friends of user from database and echo them
    $friends = $dbh->getFriends($_SESSION['username']);
    foreach ($friends as $friend) {
        echo '<a class="list-group-item list-group-item-action" href="profile.php?user=' . $dbh->getUser($friend)->getUsername() . '"> 
        
        <img src="' . $dbh->getMediaUrl($dbh->getUser($friend)->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">'

            . $dbh->getUser($friend)->getUsername() . '</a>';
    }

    ?>

</ul>