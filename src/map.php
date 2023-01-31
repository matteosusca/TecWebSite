<?php
require_once 'templates/head.php';
require_once 'bootstrap.php';
checkSession();
$user = $dbh->getUser($_SESSION['username']);

$positions = $dbh->getUsersPosition($dbh->getFriendsUsername($user->getUsername()));
$positions_json = json_encode($positions);
?>

<body class="d-flex flex-column vh-100" data-bs-theme="dark">
    <?php require_once 'templates/navbar.php'; ?>
    <div id="map" class="h-100"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        var positions = <?php echo $positions_json;?>;
    </script>
    <script src="js/localization.js"></script>
</body>

</html>