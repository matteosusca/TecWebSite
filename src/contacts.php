<?php
require_once 'bootstrap.php';
require_once 'checkSession.php';
require_once 'templates/head.php';
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php
    require_once 'templates/navbar.php'
    ?>
    <main class=" w-100">
        <div class="card m-auto w-50 mt-5">
            <div class="card-header">
                <h5 class="card-title">Contatti</h5>
            </div>
            <div class="card-body">
                <p class="card-text">nome</p>
                <p class="card-text">cognome</p>
                <p class="card-text">tel</p>
                <p class="card-text">via</p>
            </div>
            <div class="card-footer">
                <p class="card-text">grazie</p>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>


</html>