<main class="col-12 col-lg-4 p-3 shadow">
    <?php if (isset($templateParams['post']) && isset($templateParams['event'])) { ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <?php if (!empty($_POST['submitPost'])) {
                    $dbh->createPost($user, $_POST['description'], $_FILES['postfile']);
                } ?>
                <div class="card my-2">
                    <div class="card-header">
                        <h5 class="card-title"> Crea post</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <div class="form-floating">
                                <input type=" text" class="form-control bg-body" id="description" placeholder="a cosa stai pensando?" name="description" required>
                                <label for="floatingInput">a cosa stai pensando?</label>
                            </div>
                            <div>
                                <label for="formFile" class="form-label mt-2">aggiungi al tuo post</label>
                                <input type="file" class="form-control bg-body" name="postfile" id="postfile" required>
                            </div>
                            <button class="btn btn-outline-secondary mt-3 w-100" type="submit" value="Pubblica" name="submitPost">Pubblica</button>
                        </form>
                    </div>
                </div>
                <?php foreach ($templateParams["post"] as $post) { ?>
                    <div class="card my-2">
                        <div class="card-header d-flex ">
                            <img src=<?php echo $dbh->getUser($post->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="..." width="64" height="64" />
                            <div class="d-flex flex-column px-2">
                                <h5 class="card-title"><?php echo $post->getUsername() ?></h5>
                                <p class="card-text"><?php echo $post->getDate() ?></p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo $post->getDescription() ?></p>
                        </div>
                        <img src=<?php echo $post->getUrlMedia() ?> class="object-fit-contain" alt="..." height="455" />
                        <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly">
                            <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block" style="font-size: 1rem;"></i>like</button>
                            <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
                            <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comments</button>
                        </div>
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <?php if (isset($_POST['submitComment'])) {
                                $dbh->createComment($user->getUsername(), $post->getId(), $_POST['body']);
                            } ?>
                            <div class="card m-2">
                                <div class="card-header ">
                                    <h5 class="card-title"> Crea commento</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-floating">
                                            <input type=" text" class="form-control bg-body" id="body" placeholder="Scrivi un commento" name="body" required>
                                            <label for="floatingInput">Scrivi un commento</label>
                                        </div>
                                        <button class="btn btn-outline-secondary mt-2 w-100" type="submit" value="Pubblica" name="submitComment">Pubblica</button>
                                    </form>
                                </div>
                            </div>
                            <?php foreach ($dbh->getPostComments($post->getId()) as $comment) { ?>
                                <div class="card my-1 border-0">
                                    <div class="d-flex align-items-center px-2 border-0">
                                        <img src=<?php echo $dbh->getUser($comment->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="..." width="32" height="32" />
                                        <div class="d-flex flex-column px-2">
                                            <p class="card-title"><?php echo $comment->getUsername() ?></p>
                                            <p class="card-text"><?php echo $comment->getDate() ?></p>
                                        </div>
                                        <div class="card card-body">
                                            <p class="card-text"><?php echo $comment->getBody() ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <?php if (!empty($_POST['submitEvent'])) {
                    $dbh->createEvent($_POST['id'], $_POST['name'], $_POST['description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $user);
                }
                //da aggiungere controllo per creare evento anche se si è su user.php
                if (basename($_SERVER['PHP_SELF']) == "squad.php") { ?>
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title">Crea Evento</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" name="id" value=<?php echo $squad->getID(); ?>>
                                <div class="form-floating">
                                    <input type=" text" class="form-control bg-body mb-2" id="name" placeholder="Nome evento" name="name" required>
                                    <label for="floatingInput">Nome evento</label>
                                </div>
                                <div class="form-floating">
                                    <input class="form-control bg-body mb-2" id="description" rows="3" placeholder="Descrizione" name="description" required>
                                    <label for="floatingInput">Descrizione</label>
                                </div>
                                <label for="floatingInput">Data Inizio Evento</label>
                                <input type="date" class="form-control bg-body mb-2" id="event_begin_date" name="event_begin_date" required>
                                <label for="floatingInput">Data Fine Evento</label>
                                <input type="date" class="form-control bg-body mb-2" id="event_end_date" name="event_end_date" requireed>
                                <label for="floatingInput">Tipo Evento</label>
                                <select class="form-select bg-body mb-4" aria-label="Tipo Evento" name="type" required>
                                    <?php foreach ($dbh->getEventTypes() as $key => $name) {
                                        echo "<option value='" . $key . "'>" . $name . "</option>";
                                    } ?>
                                </select>
                                <button class="btn btn-outline-secondary w-100" type="submit" value="Crea" name="submitEvent">Crea</button>
                            </form>
                        </div>

                    </div>
                <?php }
                foreach ($templateParams["event"] as $event) { ?>
                    <div class="card m-2">
                        <div class="card-header">
                            <div class="d-flex align-items-center px-2 border-0">
                                <img src=<?php echo $dbh->getUser($event->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="..." width="32" height="32" />
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
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "search.php") { ?>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="true">User</button>
                <button class="nav-link" id="nav-squads-tab" data-bs-toggle="tab" data-bs-target="#nav-squads" type="button" role="tab" aria-controls="nav-squads" aria-selected="false">Squads</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab" tabindex="0">
                <?php
                if (!is_null($templateParams["user"])) { ?>
                    <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $templateParams["user"]->getUsername() ?>">
                        <img src=<?php echo $templateParams["user"]->getprofilePicture() ?> alt="" width=" 32" height="32" class="rounded-circle">
                        <?php echo $templateParams["user"]->getUsername() ?></a>
                <?php } else { ?>
                    <div class='alert alert-danger col-6' role='alert'>No user found</div>
                <?php
                } ?>
            </div>
            <div class="tab-pane fade" id="nav-squads" role="tabpanel" aria-labelledby="nav-squads-tab" tabindex="0">
                <?php
                if (!empty($templateParams["squads"])) {
                    foreach ($templateParams["squads"] as $squad) { ?>
                        <a class="list-group-item list-group-item-action" href="squad.php?squad_id=<?php echo $squad->getId() ?>">
                            <img src=<?php echo $squad->getPicture() ?> alt="" width="32" height="32" class="rounded-circle">
                            <?php echo $squad->getName() ?></a>
                    <?php }
                } else { ?>
                    <div class='alert alert-danger col-6' role='alert'>No squads found</div>
                <?php
                } ?>
            </div>
        </div>
    <?php } ?>
</main>