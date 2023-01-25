<div class="card m-2">
    <div class="card-header">
        <h5 class="card-title">Utente</h5>
        <p class="card-text">descrizione post</p>
    </div>
    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" class="object-fit-contain" alt="..." height="455" />

    <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly" ">
                    <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block" style="font-size: 1rem;"></i>like</button>
        <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comment</button>
        <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
        <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1">comment</button>
    </div>
    <div class="collapse multi-collapse" id="multiCollapseExample1">
        <?php require_once 'templates/comment.php'; ?>
    </div>
</div>