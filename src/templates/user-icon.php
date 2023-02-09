                            <a class="list-group-item list-group-item-action" href="profile.php?user=<?php echo $user->getUsername() ?>">
                                <div class="d-flex align-items-center">
                                    <div class="d-inline-flex position-relative">
                                        <span class="position-absolute top-100 start-100 translate-middle p-1 border rounded-circle" id="<?php echo $user->getUsername() ?>-span">
                                        </span>
                                        <img src=<?php echo $user->getprofilePicture() ?> alt="<?php echo $user->getUsername() ?> profile picture"  width="32" height="32" class="rounded-circle">
                                    </div>
                                    <?php echo $user->getUsername() ?>
                                </div>
                                <input type="hidden" name="user-username" value="<?php echo $user->getUsername() ?>">
                            </a>