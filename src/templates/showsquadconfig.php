<?php

if(isset($squadProfile)) {?>
    <div class="d-flex flex-lg-column justify-content-around w-100">
        <form action="editsquad.php" method="post">
            <input type="hidden" name="id" value="<?php echo $squadProfile->getId() ?>">
            <input class="btn btn-secondary my-2 w-100" type="submit" name="edit_squad" value="Edit Squad">
        </form>
        <form action="addusertosquad.php" method="post">
            <input type="hidden" name="id" value="<?php echo $squadProfile->getId() ?>">
            <input class="btn btn-secondary my-2 w-100" type="submit" name="add_user" value="Add User">
        </form>
        <form action="inviteusertoevent.php" method="post">
            <input type="hidden" name="id" value="<?php echo $squadProfile->getId() ?>">
            <input class="btn btn-secondary my-2 w-100" type="submit" name="invite_user" value="Invite User to Event">
        </form>
    </div>
<?php } ?>