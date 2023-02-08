<?php
require_once 'bootstrap.php';

$templateParams["title"] = "Map";
$templateParams["body"] = "body.php";
$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "js/localization.js", "https://maps.googleapis.com/maps/api/js?key=AIzaSyAtkgSO0EAakNnErsYTuO1ORfA4QFsnqiw&callback=initialize");
require 'templates/base.php';

?>

