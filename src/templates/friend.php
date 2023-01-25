<ul class="list-group list-group-flush offcanvas-body">
    <?php

    //get friends of user from database and echo them
    $friends = $dbh->getFriends($_SESSION['username']);
    foreach ($friends as $friend) {
        echo '<li class="list-group-item list-group-item-action">' . $friend->getUsername() . '</li>';
    }

    ?>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
    <li class="list-group-item list-group-item-action">An item</li>
    <li class="list-group-item list-group-item-action">A second item</li>
    <li class="list-group-item list-group-item-action">A third item</li>
    <li class="list-group-item list-group-item-action">A fourth item</li>
    <li class="list-group-item list-group-item-action">And a fifth one</li>
</ul>