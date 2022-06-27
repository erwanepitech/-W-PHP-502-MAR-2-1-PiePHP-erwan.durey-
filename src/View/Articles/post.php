<?php
$title = "Login";
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
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/PiePHP/user">User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/PiePHP/add-articles">Ajouter un article</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                User-Menu
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="add">Ajouter</a></li>
                                <!-- <li><a class="dropdown-item" href="/PiePHP/user/show">Profile</a></li> -->
                                <li><a class="dropdown-item active" href="login">Login</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<div class="container">
    <form action="post" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="titre">Article</label>
                <input type="text" class="form-control" id="titre" placeholder="titre" name="titre">
            </div>
            <div class="form-group col-md-6">
                <label for="content">content</label>
                <textarea name="content" id="content" cols="30" rows="10"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">poster</button>
    </form>
</div>