<?php
if (!empty($_POST['submitPost'])) {
    $dbh->createPost($_SESSION['username'], $_POST['description'], $_FILES['postfile']);
}
?>
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