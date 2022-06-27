<?php

namespace Core;

abstract class Controller
{
    protected $_render;

    protected function render($view, $scope = [])
    {
        extract($scope);
        // echo "<pre>";
        // print_r($scope);
        // echo "</pre>";
        $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', str_replace('Controller', '', basename(str_replace('src\\Controller\\', "", get_class($this)))), $view]) . '.php';
        // var_dump($f);
        if (file_exists($f)) {
            ob_start();
            include($f);
            $view = ob_get_clean();
            ob_start();
            include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
        }
    }

    protected function __destruct()
    {
        var_dump(self::$_render);
        self::$_render = ob_get_clean();
    }
}
