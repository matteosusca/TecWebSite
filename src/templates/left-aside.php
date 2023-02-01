<aside class="col-12 col-lg-2 p-3 mh-100 shadow sticky-lg-top overflow-auto d-flex flex-lg-column text-nowrap">
    <?php
    if (basename($_SERVER['PHP_SELF']) == "index.php") { ?>
        <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">friends/squads</button>
        <a class="btn btn-secondary mx-2" href="createsquad.php" type="button">Crea squad</a>
    <?php
    } else if (basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
        <div class="d-flex ">
            <div class="d-flex flex-lg-column align-items-lg-center w-100">
                <img src=<?php echo $templateParams["user"]->getProfilePicture(); ?> class="object-fit-contain rounded-circle" alt="..." width="64" height="64" />
                <div class="d-flex flex-column align-items-lg-center px-2">
                    <h5><?php echo $templateParams["user"]->getUsername() ?></h5>
                    <p> (<?php echo $templateParams["user"]->getFullName(); ?>), <?php echo  $templateParams["user"]->getAge(); ?></p>
                </div>
                <div class="d-flex flex-lg-column w-100 align-self-center">
                    <?php
                    if ($templateParams["user"]->getUsername() == $_SESSION['username']) { ?>
                        <form action="editprofile.php" method="post">
                            <input type="submit" class="btn btn-secondary border-0 w-100" value="Modifica profilo">
                        </form> <?php
                            } else { ?>
                        <form action="profile.php?user=<?php $templateParams["user"]->getUsername() ?>" method="post">
                            <input class="btn btn-secondary border-0 w-100" type="submit" <?php
                                                                                            echo (!in_array($userProfile->getUsername(), $dbh->getFriendsUsername($_SESSION['username']))) ? ' name="aggiungi" value="Aggiungi"' : ' name="rimuovi" value="Rimuovi"' ?> />
                        </form> <?php
                            } ?>
                </div>
            </div>
        </div>
    <?php
    } else if (basename($_SERVER['PHP_SELF']) == "squad.php") { ?>
        <div class="d-flex">
            <div class="d-flex flex-lg-column align-items-lg-center w-100">
                <img src=<?php echo $templateParams["squad"]->getPicture(); ?> class="object-fit-contain rounded-circle" alt="..." width="64" height="64" />
                <div class="d-flex flex-column align-items-lg-center px-2">
                    <h5 class="mx-4"><?php echo $templateParams["squad"]->getName() ?></h5>
                    <p class="mx-4"><?php echo $templateParams["squad"]->getDescription() ?></p>
                </div>
                <?php
                if ($templateParams["userCanEdit"]) { ?>
                    <div class="d-flex flex-lg-column justify-content-around w-100">
                        <form action="editsquad.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $templateParams["squad"]->getId() ?>">
                            <input class="btn btn-secondary my-2 w-100" type="submit" name="edit_squad" value="Edit Squad">
                        </form>
                        <form action="addusertosquad.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $templateParams["squad"]->getId() ?>">
                            <input class="btn btn-secondary my-2 w-100" type="submit" name="add_user" value="Add User">
                        </form>
                        <form action="inviteusertoevent.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $templateParams["squad"]->getId() ?>">
                            <input class="btn btn-secondary my-2 w-100" type="submit" name="invite_user" value="Invite User to Event">
                        </form>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    <?php
    } ?>
</aside>