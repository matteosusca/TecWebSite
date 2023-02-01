<?php if (basename($_SERVER['PHP_SELF']) == "map.php") { ?>
    <div id="map" class="h-100"></div>
    <script>
        var positions = <?php echo $positions_json; ?>;
    </script>
<?php } ?>