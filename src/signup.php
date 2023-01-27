<?php
require_once 'templates/head.php';
if (!empty($_POST['submit'])) {
    $enc_passw = md5($_POST['password'] . $salt);

    if ($dbh->signUpUser($_POST['username'], $_POST['email'], $enc_passw, $_POST['name'], $_POST['surname'], $_POST['date_of_birth'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $enc_passw;
        header("Location: index.php");
    } else {
        header("Location: signup.php?error=1");
    }
}
?>


<body class="d-flex flex-column vh-100 " data-bs-theme="dark">
    <?php
    require_once 'templates/navbar.php'
    ?>
    <main class="m-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Please sign up</h5>
            </div>
            <div class="card-body">
                <form action="signup.php" method="post">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" placeholder="name" name="name">
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="surname" placeholder="Cognome" name="surname">
                        <label for="floatingInput">Cognome</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="date_of_birth" placeholder="00/00/0000" name="date_of_birth">
                        <label for="floatingInput">Data</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" placeholder="username" name="username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="email" placeholder="name@example.com" name="email">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="password" placeholder="Password" name="password">
                        <label for="floatingPassword">Password</label>
                    </div>

                    <button class="btn btn-outline-secondary w-100" type="submit" value="Registrati" name="submit">Sign
                        up</button>
                </form>
            </div>
            <div class="card-footer ">
                <p class="text-muted">&copy; 2017–2022</p>
            </div>

        </div>

    </main>
</body>


</html>