<?php
$title_header = "Articles";
?>
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
                        <a class="nav-link active" aria-current="page" href="/PiePHP/articles">Articles</a>
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
    <h4>Voici les dérniers articles</h4>
    <!-- <pre> -->
    <?php
    // var_dump($scope);
    // $titre = $scope["Articles"][0]["titre"];
    // $contenue = $scope["Articles"][0]["contenue"];
    // $date_post = $scope["Articles"][0]["date_post"];

    ?>
    <!-- </pre> -->
    <?php for ($i = 0; $i < count($scope["Articles"]); $i++) : ?>
        <div class="articles">
            <h5><?= $scope["Articles"][$i]["title"] ?></h5>
            <p><?= $scope["Articles"][$i]["content"]; ?></p>
            <p>
                <?php if (array_key_exists("Tags", $scope["Articles"][$i])) : ?>
                    <?php
                    for ($j = 0; $j < count($scope["Articles"][$i]["Tags"]); $j++) {
                        $tags = $scope["Articles"][$i]["Tags"][$j]['name'];
                        echo "$tags ";
                    }
                    ?>
                <?php endif; ?>
            </p>
            <p>post date : <?= $scope["Articles"][$i]["date"] ?></p>
            <hr />
            <?php if (array_key_exists("Comments", $scope["Articles"][$i])) : ?>
                <p>Espace commentaire</p>
                <div class="commentaire">
                    <?php
                    for ($k = 0; $k < count($scope["Articles"][$i]["Comments"]); $k++) {
                        $comment = $scope["Articles"][$i]["Comments"][$k]['content'];
                        $date_comment = $scope["Articles"][$i]["Comments"][$k]['date'];
                        echo "<p>$comment <br>";
                        echo "$date_comment </p>";
                        echo "<hr/>";
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <br>
    <?php endfor; ?>
</div>