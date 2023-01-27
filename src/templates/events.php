    <?php
$events=$dbh->getEventsOrderByDate($_SESSION['username']);
    foreach ($events as $event) {
        echo $event->showEvent();
    }

    ?>

