<?php
if (!empty($_POST['submitEvent'])) {
    $dbh->createEvent($_POST['id'], $_POST['name'], $_POST['description'], $_POST['event_begin_date'], $_POST['event_end_date'], $_POST['type'], $_SESSION['username']);
}
?>
<div class="card my-2">
    <div class="card-header">
        <h5 class="card-title">Crea Evento</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="id" value=<?php echo $squad->getID(); ?>>
            <div class="form-floating">
                <input type=" text" class="form-control bg-body mb-2" id="name" placeholder="Nome evento" name="name" required>
                <label for="floatingInput">Nome evento</label>
            </div>
            <div class="form-floating">
                <input class="form-control bg-body mb-2" id="description" rows="3" placeholder="Descrizione" name="description" required>
                <label for="floatingInput">Descrizione</label>
            </div>
            <label for="floatingInput">Data Inizio Evento</label>
            <input type="date" class="form-control bg-body mb-2" id="event_begin_date" name="event_begin_date" required>
            <label for="floatingInput">Data Fine Evento</label>
            <input type="date" class="form-control bg-body mb-2" id="event_end_date" name="event_end_date" requireed>
            <label for="floatingInput">Tipo Evento</label>
            <select class="form-select bg-body mb-4" aria-label="Tipo Evento" name="type" required>
                <?php
                foreach ($dbh->getEventTypes() as $key => $name) {
                    echo "<option value='" . $key . "'>" . $name . "</option>";
                }
                ?>
            </select>
            <button class="btn btn-outline-secondary w-100" type="submit" value="Crea" name="submitEvent">Crea</button>
        </form>
    </div>

</div>