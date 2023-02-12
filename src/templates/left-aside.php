<aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-column text-nowrap">
    <?php if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
        <div class="d-flex flex-lg-column ">
            <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">friends/squads</button>
            <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#modalCreateSquad">create squad</button>
        </div>
    <?php }
    if (isset($templateParams['user'])) { ?>
        <div class="d-flex flex-md-row flex-lg-column align-items-lg-center">
            <div class="d-inline-flex position-relative">
                <span class="position-absolute top-100 start-100 translate-middle p-1 border rounded-circle" id="<?php echo $templateParams['user']->getUsername() ?>-span">
                </span>
                <img src=<?php echo $templateParams["user"]->getProfilePicture(); ?> class="object-fit-contain rounded-circle" alt="<?php echo $templateParams["user"]->getUsername(); ?> profile picture" width="64" height="64">
            </div>
            <div class="d-flex flex-column align-items-lg-center px-2">
                <h5 class="m-0"><?php echo $templateParams["user"]->getUsername() ?></h5>
                <p class="m-0">(<?php echo $templateParams["user"]->getFullName() ?>), <?php echo  $templateParams["user"]->getAge() ?></p>
                <p class="m-0" id=<?php echo $templateParams["user"]->getUsername() ?>></p>
                <input type="hidden" name="user-username" value="<?php echo $templateParams["user"]->getUsername() ?>">
            </div>
        </div>
        <div class="d-flex flex-lg-column">
            <?php if ($templateParams["user"]->getUsername() == $_SESSION["username"]) { ?>
                <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#modalEditProfile">edit profile</button>
                <button class="btn btn-secondary m-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">friends/squads</button>
            <?php } else { ?>
                <form action="profile.php?user=<?php echo $templateParams["user"]->getUsername() ?>" method="post" class="m-2">
                    <input class="btn btn-secondary" type="submit" <?php echo (!in_array($templateParams["user"]->getUsername(), $dbh->getFriendsUsername($_SESSION['username']))) ? ' name="aggiungi" value="Aggiungi"' : ' name="rimuovi" value="Rimuovi"' ?> />
                </form>
            <?php } ?>
        </div>
    <?php }
    if (isset($templateParams['squad'])) { ?>
        <div class="d-flex flex-md-row flex-lg-column align-items-lg-center">
            <img src=<?php echo $templateParams["squad"]->getPicture(); ?> class="object-fit-contain rounded-circle" alt="<?php echo $templateParams["squad"]->getName() ?> picture" width="64" height="64">
            <div class="d-flex flex-column align-items-lg-center px-2">
                <h5 class="mx-4"><?php echo $templateParams["squad"]->getName() ?></h5>
                <p class="mx-4"><?php echo $templateParams["squad"]->getDescription() ?></p>
            </div>
        </div>
        <?php if ($templateParams["userCanEdit"]) { ?>
            <div class="d-flex flex-lg-column">
                <button class="btn btn-secondary m-2  d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">members</button>
                <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#modalEditSquad">edit squad</button>
                <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#modalAddUserToSquad">add user</button>
                <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#modalInviteUserToEvent">invite user to event</button>
            </div>
        <?php } ?>
    <?php } ?>

</aside>