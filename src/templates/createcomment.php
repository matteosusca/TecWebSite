<?php
if (isset($dbh) && isset($user) && isset($post)) {
    if (isset($_POST['submitComment'])) {
        $dbh->createComment($user->getUsername(), $post->getId(), $_POST['body']);
    }
?>

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
<?php
}
?>