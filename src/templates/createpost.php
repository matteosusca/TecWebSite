<?php
if (!empty($_POST['submit'])) {
    $dbh->createPost($_SESSION['username'], $_POST['description'], $_FILES['postfile']);
}
?>
<div class="card m-2">
    <div class="card-header ">
        <h5 class="card-title"> Crea post</h5>
    </div>
    <div class="card-body">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <input type=" text" class="form-control bg-body" id="description" placeholder="a cosa stai pensando?" name="description" required>
            <button type="button" class="btn btn-outline-secondary border-0 disabled">aggiungi al tuo
                post</button>
            <input type="file" name="postfile" id="postfile" class="btn btn-outline-secondary border-0" required></input>
            <button class="btn btn-outline-secondary w-100" type="submit" value="Pubblica" name="submit">Pubblica</button>
        </form>
    </div>
</div>