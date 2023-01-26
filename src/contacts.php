<?php
require_once 'bootstrap.php';
require_once 'templates/head.php';
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php
    require_once 'templates/navbar.php'
    ?>
    <main class=" w-100">
        <div class="card m-auto container mt-5">
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
</body>


</html>