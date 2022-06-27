<?php
require "Core/Router.php";
// Router static
Core\Router::connect('/', ['controller' => 'app', 'action' => 'index']);

Core\Router::connect('/user', ['controller' => 'user', 'action' => 'index']);
Core\Router::connect('/add', ['controller' => 'user', 'action' => 'register']);
Core\Router::connect('/register', ['controller' => 'user', 'action' => 'add']);
Core\Router::connect('/user/profile', ['controller' => 'user', 'action' => 'show']);
Core\Router::connect('/user/profile/edit', ['controller' => 'user', 'action' => 'edit']);
Core\Router::connect('/user/profile/profile_edit', ['controller' => 'user', 'action' => 'Profile_edit']);
Core\Router::connect('/login', ['controller' => 'user', 'action' => 'login']);
Core\Router::connect('/connect', ['controller' => 'user', 'action' => 'connect']);
Core\Router::connect('/user/disconect', ['controller' => 'user', 'action' => 'disconect']);
Core\Router::connect('/user/delete', ['controller' => 'user', 'action' => 'delete']);
Core\Router::connect('/user/delete_account', ['controller' => 'user', 'action' => 'delete_account']);

Core\Router::connect('/articles', ['controller' => 'Articles', 'action' => 'show']);
Core\Router::connect('/add-articles', ['controller' => 'Articles', 'action' => 'add']);
Core\Router::connect('/post', ['controller' => 'Articles', 'action' => 'post']);
Core\Router::connect('/404', ['controller' => 'app', 'action' => 'error']);