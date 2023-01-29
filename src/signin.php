<?php
require_once 'templates/head.php';
if (!empty($_POST['submit'])) {
    $enc_passw = md5($_POST['password'] . $salt);
    if ($dbh->checkLogin($_POST['user'], $enc_passw)) {
        $_SESSION['username'] = $_POST['user'];
        header("Location: index.php");
    } else {
        header("Location: login.php?error=1");
    }
}
?>

<body class="d-flex flex-column vh-100 " data-bs-theme="dark">

    <?php require_once 'templates/navbar.php'?>
    <main class="form-signin m-auto">
        <div class="card ">
            <div class="card-header">
                <h5>Please sign in</h5>
            </div>
            <div class="card-body ">
                <form action="signin.php" method="post">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="floatingInput" placeholder="User" name="user">
                        <label for="floatingInput">User</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control bg-body mt-2" id="floatingPassword" placeholder="Password" name="password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Accedi" name="submit">Sign in</button>
                </form>
            </div>
            <div class="card-footer ">
                <a class="btn btn-outline-secondary text-bg-dark w-100" href="signup.php" type="button">sign up</a>
            </div>
        </div>
    </main>
</body>


</html>