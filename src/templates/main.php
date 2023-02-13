<main class="col-12 col-lg-4 p-3 shadow">
    <?php if (isset($templateParams['post']) && isset($templateParams['event'])) { ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                <button class="nav-link" id="nav-event-tab" data-bs-toggle="tab" data-bs-target="#nav-event" type="button" role="tab" aria-controls="nav-event" aria-selected="false">subs events</button>
                <?php if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
                    <button class="nav-link" id="nav-pub-event-tab" data-bs-toggle="tab" data-bs-target="#nav-pub-event" type="button" role="tab" aria-controls="nav-pub-event" aria-selected="false">public event</button>
                    <button class="nav-link" id="nav-event-tab" data-bs-toggle="tab" data-bs-target="#nav-event" type="button" role="tab" aria-controls="nav-event" aria-selected="false">private events</button>
                <?php } ?>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" tabindex="0">
                <?php if (!empty($_POST['submit-post'])) {
                    $dbh->createPost($user->getUsername(), $_POST['post-description'], $_FILES['post-file']);
                } ?>
                <div class="card my-2">
                    <div class="card-header">
                        <h3 class="card-title">Crea post</h3>
                    </div>
                    <div class="card-body">
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-body" id="post-description" placeholder="a cosa stai pensando?" name="post-description" required>
                                <label for="post-description">a cosa stai pensando?</label>
                            </div>
                            <div>
                                <label for="post-file" class="form-label mt-2">aggiungi al tuo post</label>
                                <input type="file" class="form-control bg-body" name="post-file" id="post-file" required>
                            </div>
                            <button class="btn btn-outline-secondary mt-3 w-100" type="submit" value="Pubblica" name="submit-post">Pubblica</button>
                        </form>
                    </div>
                </div>
                <?php foreach ($templateParams["post"] as $post) {
                    $templateParams["post"] = $post;
                    require 'post.php';
                } ?>
            </div>
            <div class="tab-pane fade" id="nav-event" role="tabpanel" tabindex="0">
                <?php
                //da aggiungere controllo per creare evento anche se si è su user.php
                if (basename($_SERVER['PHP_SELF']) == "squad.php") { ?>
                    <div class="card my-2">
                        <div class="card-header">
                            <h3 class="card-title">Crea Evento</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" name="id" value=<?php echo $squad->getID(); ?>>
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-body mb-2" id="name" placeholder="Nome evento" name="name" required>
                                    <label for="name">Nome evento</label>
                                </div>
                                <div class="form-floating">
                                    <label for="event-description">Descrizione</label>
                                    <input class="form-control bg-body mb-2" id="event-description" placeholder="Descrizione" name="event-description" required>
                                </div>
                                <label for="event_begin_date">Data Inizio Evento</label>
                                <input type="date" class="form-control bg-body mb-2" id="event_begin_date" name="event_begin_date" required>
                                <label for="event_end_date">Data Fine Evento</label>
                                <input type="date" class="form-control bg-body mb-2" id="event_end_date" name="event_end_date" required>
                                <label for="type">Tipo Evento</label>
                                <select class="form-select bg-body mb-4" id="type" name="type" required>
                                    <option value="" disabled selected>Seleziona un tipo di evento</option>
                                    <?php foreach ($dbh->getEventTypes() as $key => $name) {
                                        echo "<option value='" . $key . "'>" . $name . "</option>";
                                    } ?>
                                </select>
                                <button class="btn btn-outline-secondary w-100" type="submit" value="Crea" name="submit-event">Crea</button>
                            </form>
                        </div>

                    </div>
                <?php }
                foreach ($templateParams["event"] as $event) { ?>
                    <div class="card m-2">
                        <div class="card-header">
                            <div class="d-flex align-items-center px-2 border-0">
                                <img src=<?php echo $dbh->getUser($event->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="event author profile picture" width="32" height="32">
                                <div class="d-flex flex-column px-2">
                                    <p class="card-title"><?php echo $event->getName() ?>(<?php echo $event->getUsername() ?>)</p>
                                    <p class="card-text">dal <?php echo $event->getDateOfEventStart() ?> al <?php echo $event->getDateOfEventEnd() ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body">
                            <p class="card-text"><?php echo $event->getDescription() ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane fade" id="nav-pub-event" role="tabpanel" tabindex="0">
                <?php foreach ($templateParams["pub-events"] as $event) {
                    $templateParams["event"] = $event;
                    require 'event.php';
                } ?>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "search.php") { ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="true">User</button>
                <button class="nav-link" id="nav-squads-tab" data-bs-toggle="tab" data-bs-target="#nav-squads" type="button" role="tab" aria-controls="nav-squads" aria-selected="false">Squads</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-user" role="tabpanel" tabindex="0">
                <?php
                if (!empty($templateParams["users"])) {
                    foreach ($templateParams["users"] as $profile) { ?>
                        <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $profile->getUsername() ?>">
                            <img src=<?php echo $profile->getprofilePicture() ?> alt=<?php echo $profile->getUsername() ?> width="64" height="64" class="rounded-circle">
                            <?php echo $profile->getUsername() ?></a>
                <?php }
                } else {
                    alert("No users found");
                } ?>
            </div>
            <div class="tab-pane fade" id="nav-squads" role="tabpanel" tabindex="0">
                <?php
                if (!empty($templateParams["squads"])) {
                    foreach ($templateParams["squads"] as $squad) { ?>
                        <a class="list-group-item list-group-item-action" href="squad.php?squad_id=<?php echo $squad->getId() ?>">
                            <img src=<?php echo $squad->getPicture() ?> alt=<?php echo $squad->getName() ?> picture" width="64" height="64" class="rounded-circle">
                            <?php echo $squad->getName() ?></a>
                <?php }
                } else {
                    alert("No squads found");
                } ?>
            </div>
        </div>
    <?php } ?>
</main>