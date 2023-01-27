<div class="card">
    <div class="card-header">
        <h5 class="card-title">Crea Evento</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type=" text" class="form-control bg-body mb-2" id="name" placeholder="Nome evento" name="name" required>
            <textarea class="form-control bg-body mb-2" id="description" rows="3" placeholder="Descrizione" name="description" required></textarea>
            <label for="floatingInput">Data Inizio Evento</label>
            <input type="date" class="form-control mb-2" id="event_begin_date" name="event_begin_date">
            <label for="floatingInput">Data Fine Evento</label>
            <input type="date" class="form-control mb-2" id="event_end_date" name="event_end_date">
            <label for="floatingInput">Tipo Evento</label>
            <select class="form-select mb-4" aria-label="Tipo Evento" name="type">
                <?php
                foreach ($dbh->getEventTypes() as $key => $name) {
                    echo "<option value='" . $key . "'>" . $name . "</option>";
                }
                ?>
            </select>
            <button class="btn btn-outline-secondary w-100" type="submit" value="Crea" name="submit">Crea</button>
        </form>
    </div>

</div>