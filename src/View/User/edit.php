<?php
$title = "Édition";
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="nav-link" href="/PiePHP">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                User-Menu
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php if (isset($_SESSION["user"])) : ?>
                                    <li><a class="dropdown-item active" href="/PiePHP/user/profile">Profile</a></li>
                                    <li><a class="dropdown-item" href="/PiePHP/user/disconect">déconnexion</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<div class="container">
    <form action="/PiePHP/user/profile_edit" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email" value="<?= $email ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">current Password</label>
                <input type="password" class="form-control" id="inputPassword4" placeholder="password" name="password_user">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">new password</label>
                <input type="password" class="form-control" id="inputPassword4" placeholder="new password" name="new_password">
            </div>
            <span class="error_msg">
                <?php if (array_key_exists("error", $scope)) : ?>
                    <?= $scope["error"] ?>
                <?php endif; ?>
            </span>
            <br>
        </div>
        <button type="submit" class="btn btn-primary">modifier</button>
    </form>
    <br>
    <form action="/PiePHP/user/delete_account" method="POST">
        <button type="submit" class="btn btn-danger">supprimer</button>
    </form>
</div>