<main class="col-12 col-lg-4 p-3 shadow">    
<?php 
if(basename($_SERVER['PHP_SELF']) == "index.php" || basename($_SERVER['PHP_SELF']) == "squad.php" || basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
        <?php
        if(isset($templateParams['post']) && isset($templateParams['event'])) {?>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">post</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">event</button>
                </div>
            </nav>
        <?php
        }?>
        
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <?php require 'templates/createpost.php';
                foreach ($templateParams["post"] as $post) {
                    require 'templates/showpost.php';
                } ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <?php 
                echo basename($_SERVER['PHP_SELF']);
                //da aggiungere controllo per creare evento anche se si è su user.php
                if(basename($_SERVER['PHP_SELF']) == "squad.php") {
                    require 'templates/createevent.php';
                }
                foreach ($templateParams["event"] as $event) {
                    require 'templates/showevent.php';
                } ?>
            </div>
        </div>
<?php } else if(basename($_SERVER['PHP_SELF']) == "signin.php") { ?>
    <div class="card ">
        <div class="card-header">
            <h5>Please sign in</h5>
        </div>
        <div class="card-body">
            <form action="signin.php" method="post">
                <div class="form-floating">
                    <input type="text" class="form-control bg-body" id="floatingInput" placeholder="User" name="user" required>
                    <label for="floatingInput">User</label>
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
<?php } else if(basename($_SERVER['PHP_SELF']) == "contacts.php") { ?>
    <div class="card m-auto container mt-5">
        <div class="card-header">
            <h5 class="card-title">Contatti</h5>
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
<?php } else if(basename($_SERVER['PHP_SELF']) == "search.php") { ?>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="true">User</button>
            <button class="nav-link" id="nav-squads-tab" data-bs-toggle="tab" data-bs-target="#nav-squads" type="button" role="tab" aria-controls="nav-squads" aria-selected="false">Squads</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab" tabindex="0"> 
            <?php 
            if(!is_null($templateParams["user"])) {
                echo $templateParams["user"]->showUser();
            } else {?>
                <div class='alert alert-danger col-6' role='alert'>No user found</div>
            <?php
            }?>
        </div>
        <div class="tab-pane fade" id="nav-squads" role="tabpanel" aria-labelledby="nav-squads-tab" tabindex="0">
            <?php 
            if(!empty($templateParams["squads"])) {
                foreach($templateParams["squads"] as $squad) {
                    echo $squad->showSquad();
                }
            } else { ?>
                <div class='alert alert-danger col-6' role='alert'>No squads found</div>
            <?php
            }?>
        </div>
    </div>
<?php } else if(basename($_SERVER['PHP_SELF']) == "signup.php") { ?>
    <div class="card">
        <div class="card-header">
            <h5>Please sign up</h5>
        </div>
        <div class="card-body">
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="form-floating">
                    <input type="text" class="form-control bg-body" id="name" placeholder="name" name="name" required>
                    <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control bg-body mt-2" id="surname" placeholder="Cognome" name="surname" required> 
                    <label for="floatingInput">Cognome</label>
                </div>
                <div class="form-floating">
                    <input type="date" class="form-control bg-body mt-2" id="date_of_birth" placeholder="00/00/0000" name="date_of_birth" required>
                    <label for="floatingInput">Data</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control bg-body mt-2" id="username" placeholder="username" name="username" required>
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control bg-body mt-2" id="email" placeholder="name@example.com" name="email" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control bg-body mt-2" id="password" placeholder="Password" name="password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div>
                    <label for="formFile" class="form-label mt-2">aggiungi una foto</label>
                    <input type="file" class="form-control bg-body" name="profilefile" id="profilefile" required>
                </div>
                <button class="btn btn-outline-secondary text-bg-dark w-100 mt-3" type="submit" value="Registrati" name="submit">Sign
                    up</button>
            </form>
        </div>
    </div>
<?php } else if(basename($_SERVER['PHP_SELF']) == "") { ?>


<?php } else if(basename($_SERVER['PHP_SELF']) == "") { ?>


<?php } else if(basename($_SERVER['PHP_SELF']) == "") { ?>

<?php } ?>
</main>