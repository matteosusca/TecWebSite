<h5>Members</h5>
<ul class="list-group list-group-flush offcanvas-body">
    <?php
    //get members of the squad and echo them
    foreach ($squadProfile->getMembers() as $member) {
        echo '<li class="list-group-item list-group-item-action">' .

            '<img src="' . $dbh->getMediaUrl($dbh->getUser($member)->getProfilePicture()) . '" alt="" width="32" height="32" class="rounded-circle">'
            . $member . '</li>';
    }
    ?>
</ul>