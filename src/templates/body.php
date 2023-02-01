<?php if (basename($_SERVER['PHP_SELF']) == "map.php") { ?>
    <div id="map" class="h-100"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        var positions = <?php echo $positions_json; ?>;
    </script>
    <script src="js/localization.js"></script>
<?php } ?>