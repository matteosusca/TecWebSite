<?php
require_once 'bootstrap.php';

if (!empty($_POST['submit'])) {
    if($dbh->createSquad($_POST['name'], $_POST['description'], $_SESSION['username'])){
        header("Location: squadpage.php?name=".$_POST['name']."");
    } else {
        header("Location: createsquad.php?error=1");
    }   
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Pagina di creazione Squad</title>
</head>

<body>
    <form action="createsquad.php" method="post">
        <label for="name">Nome squad:</label>
        <input type="text" id="name" name="name">
        <br>
        <label for="description">Descrizione:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>
        <br>
        <input type="submit" value="Crea squadra">
    </form>
</body>

</html>