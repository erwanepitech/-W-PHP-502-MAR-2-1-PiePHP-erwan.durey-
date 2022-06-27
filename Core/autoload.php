<?php

/**
 * Autoloader dynamique
 * À chaque fois qu'on voudra instencier une class,
 * l'autoloader verifie si un script existe (avec le nom de la class)
 * si c'est le cas alors on requerie le fichier
 */

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    } else {
        // throw new \Exception("Impossible de charger $class.");
        return false;
    }
});