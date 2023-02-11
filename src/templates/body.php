<?php if (basename($_SERVER['PHP_SELF']) == "map.php") { ?>
    <div id="map" class="h-100"></div>
<?php } else { ?>
<div class="m-auto">
    <?php if (basename($_SERVER['PHP_SELF']) == "signin.php") { ?>
        <div class="card ">
            <div class="card-header">
                <h5>Please sign in</h5>
            </div>
            <div class="card-body">
                <form action="signin.php" method="post">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="user" placeholder="User" name="user" required>
                        <label for="user">User</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control bg-body mt-2" id="floatingPassword" placeholder="Password" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Accedi" name="submit">Sign in</button>
                </form>
            </div>
            <div class="card-footer ">
                <a class="btn btn-outline-secondary text-bg-dark w-100" href="signup.php" type="button">sign up</a>
            </div>
        </div>
    <?php } else if (basename($_SERVER['PHP_SELF']) == "contacts.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5>Contatti</h5>
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
    <?php } else if (basename($_SERVER['PHP_SELF']) == "signup.php") { ?>
        <div class="card">
            <div class="card-header">
                <h5>Please sign up</h5>
            </div>
            <div class="card-body">
                <form action="signup.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body" id="name" placeholder="name" name="name" required>
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="surname" placeholder="Cognome" name="surname" required>
                        <label for="surname">Cognome</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control bg-body mt-2" id="date_of_birth" name="date_of_birth" required>
                        <label for="date_of_birth">Data</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="username" placeholder="username" name="username" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control bg-body mt-2" id="email" placeholder="name@example.com" name="email" required>
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control bg-body mt-2" id="password" placeholder="Password" name="password" required>
                        <label for="password">Password</label>
                    </div>
                    <div>
                        <label for="profilepic" class="form-label mt-2">aggiungi una foto</label>
                        <input type="file" class="form-control bg-body" name="profilefile" id="profilepic" required>
                    </div>
                    <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Registrati" name="submit">Sign
                        up</button>
                </form>
            </div>
        </div>
     <?php } ?>
    </div>
<?php } ?>