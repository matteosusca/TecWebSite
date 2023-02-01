<main class="col-12 col-lg-4 p-3 shadow">
    <?php
    if (basename($_SERVER['PHP_SELF']) == "index.php" || basename($_SERVER['PHP_SELF']) == "squad.php" || basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
        <?php
        if (isset($templateParams['post']) && isset($templateParams['event'])) { ?>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
                </div>
            </nav>
        <?php } ?>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <?php
                if (!empty($_POST['submitPost'])) {
                    $dbh->createPost($_SESSION['username'], $_POST['description'], $_FILES['postfile']);
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
                            <?php
                            if (isset($dbh) && isset($user) && isset($post)) {
                                if (isset($_POST['submitComment'])) {
                                    $dbh->createComment($user->getUsername(), $post->getId(), $_POST['body']);
                                }
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
                            <?php }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <?php
                if (!empty($_POST['submitEvent'])) {
                    $dbh->createEvent($_POST['id'], $_POST['name'], $_POST['description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $_SESSION['username']);
                }
                //da aggiungere controllo per creare evento anche se si è su user.php
                if (basename($_SERVER['PHP_SELF']) == "squad.php") {
                ?>
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
                                    <?php
                                    foreach ($dbh->getEventTypes() as $key => $name) {
                                        echo "<option value='" . $key . "'>" . $name . "</option>";
                                    }
                                    ?>
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
    <?php } else if (basename($_SERVER['PHP_SELF']) == "signin.php") { ?>
        <div class="card ">
            <div class="card-header">
                <h5>Please sign in</h5>
            </div>
            <div class="card-body">
                <form action="signin.php" method="post">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="floatingInput" placeholder="User" name="user" required>
                        <label for="floatingInput">User</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control bg-body mt-2" id="floatingPassword" placeholder="Password" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Accedi" name="submit">Sign in</button>
                </form>
            </div>
            <div class="card-footer ">
                <a class="btn btn-outline-secondary text-bg-dark w-100" href="signup.php" type="button">sign up</a>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "contacts.php") { ?>
        <div class="card m-auto container mt-5">
            <div class="card-header">
                <h5 class="card-title">Contatti</h5>
            </div>
            <div class="card-body">
                <p class="card-text">nome</p>
                <p class="card-text">cognome</p>
                <p class="card-text">tel</p>
                <p class="card-text">via</p>
            </div>
            <div class="card-footer">
                <p class="card-text">grazie</p>
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
                if (!is_null($templateParams["user"])) {
                    echo $templateParams["user"]->showUser();
                } else { ?>
                    <div class='alert alert-danger col-6' role='alert'>No user found</div>
                <?php
                } ?>
            </div>
            <div class="tab-pane fade" id="nav-squads" role="tabpanel" aria-labelledby="nav-squads-tab" tabindex="0">
                <?php
                if (!empty($templateParams["squads"])) {
                    foreach ($templateParams["squads"] as $squad) {
                        echo $squad->showSquad();
                    }
                } else { ?>
                    <div class='alert alert-danger col-6' role='alert'>No squads found</div>
                <?php
                } ?>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "signup.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5>Please sign up</h5>
            </div>
            <div class="card-body">
                <form action="signup.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="name" placeholder="name" name="name" required>
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="surname" placeholder="Cognome" name="surname" required>
                        <label for="floatingInput">Cognome</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control bg-body mt-2" id="date_of_birth" placeholder="00/00/0000" name="date_of_birth" required>
                        <label for="floatingInput">Data</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="username" placeholder="username" name="username" required>
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="email" placeholder="name@example.com" name="email" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control bg-body mt-2" id="password" placeholder="Password" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div>
                        <label for="formFile" class="form-label mt-2">aggiungi una foto</label>
                        <input type="file" class="form-control bg-body" name="profilefile" id="profilefile" required>
                    </div>
                    <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Registrati" name="submit">Sign
                        up</button>
                </form>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "addusertosquad.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add user to <?php echo $templateParams["squad"]->getName() ?> group</h5>
            </div>
            <div class="card-body">
                <form action="addusertosquad.php" method="post">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getId(); ?>>
                    <div class="row mx-0">
                        <select name="user_friend" class="btn btn-outline-secondary col-12" id="user_friend">
                            <option value="" disabled selected>Seleziona un amico</option>
                            <?php
                            foreach ($templateParams["user"]->getFriends() as $friend) {
                                if (!$dbh->isUserMember($friend, $templateParams["squad"]->getId())) {
                                    echo "<option value='" . $friend . "' >" . $friend . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">Or search for a user</button>

                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" name="searched_user" id="searched_user" placeholder="User">
                        <label for="floatingInput">User</label>
                    </div>
                    <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">As</button>
                    <select name="role" class="btn btn-outline-secondary col-12 mb-2" id="role" required>
                        <option value="" disabled selected>Seleziona un ruolo</option>
                        <option value="2">admin</option>
                        <option value="3">member</option>
                    </select>
                    <input class="btn btn-outline-secondary w-100" type="submit" name="save" value="Add User"></input>
                </form>
            </div>
        </div>

    <?php } else if (basename($_SERVER['PHP_SELF']) == "createsquad.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5>Create new squad</h5>
            </div>
            <div class="card-body">
                <form action="createsquad.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="name" placeholder="Nome squad" name="name" required>
                        <label for="name">Nome squad</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control bg-body mt-2" id="description" name="description" placeholder="Descrizione" required></textarea>
                        <label for="description">Descrizione</label>
                    </div>
                    <div>
                        <label for="formFile" class="form-label">Squad Picture</label>
                        <input type="file" class="form-control bg-body" name="squadPicture" id="squadPicture" required>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>

    <?php } else if (basename($_SERVER['PHP_SELF']) == "editprofile.php") { ?>
        <div class="card">
            <?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                <p>Mail already in use</p>
            <?php } ?>
            <div class="card-header">
                <h5>Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="editprofile.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="formFile" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control bg-body" name="profilePicture" id="profilePicture">
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $templateParams["user"]->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="surname" id="surname" value="<?php echo $templateParams["user"]->getSurname() ?>">
                        <label for="name">Surname</label>
                    </div>
                    <div class="form-floating">
                        <input type="email" class="form-control bg-body mt-2" name="email" id="email" value="<?php echo $templateParams["user"]->getEmail() ?>">
                        <label for="name">Email</label>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "editsquad.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5>Edit <?php echo $templateParams["squad"]->getName() ?> squad</h5>
            </div>
            <div class="card-body">
                <form action="editsquad.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getID(); ?>>
                    <div>
                        <label for="formFile" class="form-label">Squad Picture</label>
                        <input type="file" class="form-control bg-body" name="squadPicture" id="formFile">
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $templateParams["squad"]->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input name="text" class="form-control bg-body mt-2" name="description" id="description" value="<?php echo $templateParams["squad"]->getDescription() ?>">
                        <label for="description">Description</label>
                    </div>
                    <div class="row mx-0">
                        <select name="user" class="col form-select bg-body mt-2  me-2" id="user">
                            <option value="" disabled selected>Seleziona un utente</option>
                            <?php
                            foreach ($templateParams["squad"]->getMembers() as $user) {
                                echo "<option value='" . $user . "' >" . $user . "</option>";
                            }
                            ?>
                        </select>
                        <select name="action" class="col form-select bg-body mt-2" id="action">
                            <option value="admin">Make admin</option>
                            <option value="member">Make member</option>
                            <option value="remove">Remove from squad</option>
                        </select>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" href="editsquad.php" type="submit" name="save" value="Save"></input>
                </form>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "inviteusertoevent.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add user to <?php echo $templateParams["squad"]->getName() ?> group</h5>
            </div>
            <div class="card-body">
                <form action="inviteusertoevent.php" method="post">
                    <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getId(); ?>>
                    <select name="event" class="col form-select bg-body" id="event" required>
                        <option value="" disabled selected>evento</option>
                        <?php
                        foreach ($templateParams["event"] as $event) {
                            echo "<option value='" . $event->getIdEvent() . "' >" . $event->getName() . "</option>";
                        }
                        ?>
                    </select>
                    <select name="user" class="col mt-2 form-select bg-body" id="user" required>
                        <option value="" disabled selected>utente</option>
                        <?php
                        foreach ($templateParams["squad"]->getMembers() as $user) {
                            echo "<option value='" . $user . "' >" . $user . "</option>";
                        }
                        ?>
                    </select>
                    <input class="btn btn-outline-secondary mt-3 w-100" type="submit" name="invita" value="Invite User"></input>
                </form>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "map.php") { ?>
        <div id="map" class="h-100"></div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            var positions = <?php echo $positions_json; ?>;
        </script>
        <script src="js/localization.js"></script>
    <?php } ?>

</main>