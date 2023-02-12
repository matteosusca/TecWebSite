<div class="modal fade" id="modalNotification" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Friend Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Two buttons to accept or decline the friend request -->
                    <div class="d-flex justify-content-between">
                        
                        <button type="button" id="accept" class="btn btn-outline-success">Accept</button>
                        <button type="button" id="decline" class="btn btn-outline-danger">Decline</button>
                        <input type="hidden" id="sender_accept">
                        <input type="hidden" id="sender_decline">
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
    <div class="modal fade" id="modalCreateSquad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Create Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="name" placeholder="Nome squad" name="name" required>
                        <label for="name">Nome squad</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control bg-body mt-2" id="description" name="description" placeholder="Descrizione" required></textarea>
                        <label for="description">Descrizione</label>
                    </div>
                    <div>
                        <label for="squadPicture" class="form-label">Squad Picture</label>
                        <input type="file" class="form-control bg-body" name="squadPicture" id="squadPicture" required>
                    </div>
                    <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" type="submit" name="save" value="Save">
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if (isset($templateParams['user'])) { ?>
    <div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                            <p>Mail already in use</p>
                        <?php } ?><div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="profilePicture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control bg-body" name="profilePicture" id="profilePicture">
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control bg-body mt-2" name="name" id="name" value="<?php echo $userProfile->getName() ?>">
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control bg-body mt-2" name="surname" id="surname" value="<?php echo $userProfile->getSurname() ?>">
                                <label for="surname">Surname</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control bg-body mt-2" name="email" id="email" value="<?php echo $userProfile->getEmail() ?>">
                                <label for="email">Email</label>
                            </div>
                            <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" type="submit" name="save" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if (isset($templateParams['squad'])) {  ?>
    <div class="modal fade" id="modalEditSquad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form action="" method="post" enctype="multipart/form-data">
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
                                <input type="text" class="form-control bg-body mt-2" name="description" id="description" value="<?php echo $templateParams["squad"]->getDescription() ?>">
                                <label for="description">Description</label>
                            </div>
                            <div class="row mx-0">
                                <label for="user" class="visually-hidden">User</label>
                                <select name="user" class="col form-select bg-body mt-2  me-2" id="user">
                                    <option value="" disabled selected>Seleziona un utente</option>
                                    <?php
                                    foreach ($templateParams["squad"]->getMembers() as $user) {
                                        echo "<option value='" . $user . "' >" . $user . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="action" class="visually-hidden">Role for the user</label>
                                <select name="action" class="col form-select bg-body mt-2" id="action">
                                    <option value="admin">Make admin</option>
                                    <option value="member">Make member</option>
                                    <option value="remove">Remove from squad</option>
                                </select>
                            </div>
                            <input class="btn btn-outline-secondary text-bg-dark mt-3 w-100" type="submit" name="save" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddUserToSquad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form action="" method="post">
                            <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getID(); ?>>
                            <div class="row mx-0">
                                <label for="user_friend" class="visually-hidden">Select friend to add</label>
                                <select name="user_friend" class="btn btn-outline-secondary col-12" id="user_friend">
                                    <option value="" disabled selected>Seleziona un amico</option>
                                    <?php
                                    foreach ($templateParams["friends"] as $friend) {
                                        if (!$dbh->isUserMember($friend->getUsername(), $templateParams["squad"]->getId())) {
                                            echo "<option value='" . $friend->getUsername() . "' >" . $friend->getUsername() . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">Or search for a user</button>

                            <div class="form-floating">
                                <input type="text" class="form-control bg-body" name="searched_user" id="searched_user" placeholder="User">
                                <label for="searched_user">User</label>
                            </div>
                            <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">As</button>
                            <label for="role" class="visually-hidden">Select a role for the new user</label>
                            <select name="role" class="btn btn-outline-secondary col-12 mb-2" id="role" required>
                                <option value="" disabled selected>Seleziona un ruolo</option>
                                <option value="2">admin</option>
                                <option value="3">member</option>
                            </select>
                            <input class="btn btn-outline-secondary w-100" type="submit" name="add" value="Add User">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalInviteUserToEvent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form action="" method="post">
                            <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getID(); ?>>
                            <div class="row mx-0">
                                <label for="user_friend" class="visually-hidden">Select friend to add</label>
                                <select name="user_friend" class="btn btn-outline-secondary col-12" id="user_friend">
                                    <option value="" disabled selected>Seleziona un amico</option>
                                    <?php
                                    foreach ($templateParams["friends"] as $friend) {
                                        if (!$dbh->isUserMember($friend->getUsername(), $templateParams["squad"]->getId())) {
                                            echo "<option value='" . $friend->getUsername() . "' >" . $friend->getUsername() . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">Or search for a user</button>

                            <div class="form-floating">
                                <input type="text" class="form-control bg-body" name="searched_user" id="searched_user" placeholder="User">
                                <label for="searched_user">User</label>
                            </div>
                            <button type="button" class="btn btn-outline-secondary border-0 disabled col-12">As</button>
                            <label for="role" class="visually-hidden">Select a role for the new user</label>
                            <select name="role" class="btn btn-outline-secondary col-12 mb-2" id="role" required>
                                <option value="" disabled selected>Seleziona un ruolo</option>
                                <option value="2">admin</option>
                                <option value="3">member</option>
                            </select>
                            <input class="btn btn-outline-secondary w-100" type="submit" name="add" value="Add User">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }  ?>