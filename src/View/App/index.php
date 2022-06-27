<?php
$title_header = "Home";
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="nav-link active" href="/PiePHP">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/PiePHP/articles">Articles</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                User-Menu
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php if (isset($_SESSION["user"])) : ?>
                                    <li><a class="dropdown-item active" href="/PiePHP/user/profile">Profile</a></li>
                                    <li><a class="dropdown-item" href="/PiePHP/user/disconect">déconnexion</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="/PiePHP/register">Ajouter</a></li>
                                    <li><a class="dropdown-item" href="/PiePHP/login">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <h4>Bienvenue sur PiePHP</h4>
    </div>
</header>