<?php
require_once 'templates/head.php';
require_once 'bootstrap.php';
checkSession();
$user = $dbh->getUser($_SESSION['username']);
?>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div id="map-canvas" class="h-100"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src=" <?php echo "js/localization.js";?>"></script>
</body>

</html>