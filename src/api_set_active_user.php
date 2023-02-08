<?php

require 'bootstrap.php';

if (isset($_SESSION["username"])) {
    $dbh->setLastActivity($_SESSION["username"], date("Y-m-d H:i:s", time()));
}


?>