<div class="m-auto">
    <?php if (basename($_SERVER['PHP_SELF']) == "map.php") { ?>
        <div id="map" class="h-100"></div>
        <script>
            var positions = <?php echo $positions_json; ?>;
        </script>
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
        <div class="card">
            <div class="card-header">
                <h5>Contatti</h5>
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
                            foreach ($user->getFriends() as $friend) {
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
                        <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $user->getName() ?>">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" name="surname" id="surname" value="<?php echo $user->getSurname() ?>">
                        <label for="name">Surname</label>
                    </div>
                    <div class="form-floating">
                        <input type="email" class="form-control bg-body mt-2" name="email" id="email" value="<?php echo $user->getEmail() ?>">
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
    <?php } ?>
</div>