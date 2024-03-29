<?php
if (!empty($_POST['registration_action'])) {
    switch ($_POST['registration_action']) {
        case 'register':
            $dbh->registerUserToEvent($user->getUsername(), $_POST['event_id']);
            break;
        case 'unregister':
            $dbh->unregisterUserFromEvent($user->getUsername(), $_POST['event_id']);
            break;
    }
}
?>

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
                    <button type="button" id="accept" class="btn btn-outline-success" data-bs-dismiss="modal">Accept</button>
                    <button type="button" id="decline" class="btn btn-outline-danger" data-bs-dismiss="modal">Decline</button>
                    <input type="hidden" id="sender">
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (checkSession()) {
    foreach ($dbh->getRegisteredEventsOrderByDate($_SESSION["username"]) as $eventNotification) { ?>
        <div class="modal fade" id="modalNotificationEvent<?php echo $eventNotification->getIdEvent() ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $templateParams["event"] = $eventNotification;
                        require 'event.php'
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>
<?php if (checkSession()) {
    foreach ($dbh->getPostOrderByDate($_SESSION["username"]) as $postNotification) { ?>
        <div class="modal fade" id="modalNotificationPost<?php echo $postNotification->getId() ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card my-2">
                            <div class="card-header d-flex ">
                                <img src=<?php echo $dbh->getUser($postNotification->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="post author profile picture" width="64" height="64">
                                <div class="d-flex flex-column px-2">
                                    <h3 class="card-title"><?php echo $postNotification->getUsername() ?></h3>
                                    <p class="card-text"><?php echo $postNotification->getDate() ?></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?php echo $postNotification->getDescription() ?></p>
                            </div>
                            <img src=<?php echo $postNotification->getUrlMedia() ?> class="object-fit-contain" alt="post media" height="455">
                            <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly">
                                <button type="button" class="btn btn-outline-secondary border-0" name="like-btn" value="<?php echo $postNotification->getId() ?>">
                                    <?php if ($dbh->isLiked($postNotification->getId(), $user->getUsername())) { ?>
                                        <em class="bi bi-hand-thumbs-up-fill d-block position-relative">
                                        <?php } else { ?>
                                            <em class="bi bi-hand-thumbs-up d-block position-relative">
                                            <?php } ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" id="<?php echo $postNotification->getId() ?>-notification-like-count"></span></em>
                                            like
                                </button>
                                <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target="#notification<?php echo $postNotification->getId() ?>" aria-expanded="false" aria-controls="<?php echo $postNotification->getId() ?>"><em class="bi bi-pencil-square d-block"></em>comments</button>
                            </div>
                            <div class="collapse multi-collapse" id="notification<?php echo $postNotification->getId() ?>">
                                <div class="card m-2">
                                    <div class="card-header ">
                                        <h4 class="card-title">Crea commento</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="#" method="post" enctype="multipart/form-data">
                                            <div class="form-floating">
                                                <input type="text" class="form-control bg-body" id="notification_comment_body_post#<?php echo $postNotification->getId() ?>" placeholder="Scrivi un commento" name="body" required>
                                                <label for="notification_comment_body_post#<?php echo $postNotification->getId() ?>">Scrivi un commento</label>
                                            </div>
                                            <button class="btn btn-outline-secondary mt-2 w-100" type="submit" value="Pubblica" name="submitComment<?php echo $postNotification->getId() ?>">Pubblica</button>
                                        </form>
                                    </div>
                                </div>
                                <?php foreach ($dbh->getPostComments($postNotification->getId()) as $comment) { ?>
                                    <div class="card my-1 border-0">
                                        <div class="d-flex align-items-center px-2 border-0">
                                            <img src=<?php echo $dbh->getUser($comment->getUsername())->getProfilePicture() ?> class="object-fit-contain rounded-circle" alt="comment author profile picture" width="32" height="32">
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

                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>
<?php if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
    <div class="modal fade" id="modalCreateSquad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Create Squad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
<?php } else if (isset($templateParams['user'])) { ?>
    <div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                        <p>Mail already in use</p>
                    <?php } ?>
                    <div class="modal-body">
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
                                <?php foreach ($templateParams["squad"]->getMembers() as $profile) {
                                    echo "<option value='" . $profile . "' >" . $profile . "</option>";
                                } ?>
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

    <div class="modal fade" id="modalAddUserToSquad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getID(); ?>>
                        <div class="row mx-0">
                            <label for="user_friend" class="visually-hidden">Select friend to add</label>
                            <select name="user_friend" class="btn btn-outline-secondary col-12" id="user_friend">
                                <option value="" disabled selected>Seleziona un amico</option>
                                <?php foreach ($templateParams["friends"] as $friend) {
                                    if (!$dbh->isUserMember($friend->getUsername(), $templateParams["squad"]->getId())) {
                                        echo "<option value='" . $friend->getUsername() . "' >" . $friend->getUsername() . "</option>";
                                    }
                                } ?>
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
    <div class="modal fade" id="modalInviteUserToEvent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>invite user to event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" class="form-control" name="id" value=<?php echo $templateParams["squad"]->getId(); ?>>
                        <label for="event" class="visually-hidden">Event</label>
                        <select name="event" class="col form-select bg-body" id="event" required>
                            <option value="" disabled selected>evento</option>
                            <?php
                            foreach ($templateParams["event"] as $event) {
                                echo "<option value='" . $event->getIdEvent() . "' >" . $event->getName() . "</option>";
                            }
                            ?>
                        </select>
                        <label for="user" class="visually-hidden">User to add</label>
                        <select name="user" class="col mt-2 form-select bg-body" id="user" required>
                            <option value="" disabled selected>utente</option>
                            <?php
                            foreach ($templateParams["squad"]->getMembers() as $user) {
                                echo "<option value='" . $user . "' >" . $user . "</option>";
                            }
                            ?>
                        </select>
                        <input class="btn btn-outline-secondary mt-3 w-100" type="submit" name="invita" value="Invite User">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }  ?>