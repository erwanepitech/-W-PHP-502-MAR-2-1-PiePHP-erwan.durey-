<?php

namespace Core;

class Core
{
    /**
     * function run
     * (Router Hybride)
     *
     * @param  mixed $url url du site pour les routes
     * @return void
     */
    public function run($url)
    {
        /**
         * on require & instencie le router 
         * on defini le namespace pour les verification
         */
        ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
        session_start();
        require("src/routes.php");
        $route = Router::get($url);
        $namespace = "\\src\\Controller";
        /**
         * si une class/methode existe avec la route static on l'utilise
         */
        if (
            class_exists($namespace . "\\" . ucfirst($route["Controller"] . "Controller"))
            && method_exists($namespace . "\\" . ucfirst($route["Controller"] . "Controller"), $route["Action"] . "Action")
        ) {
            $class_name = $route["Controller"] . "Controller";
            $method = $route["Action"] . "Action";
            /**
             * Sinon si on detect des params get dans l'url on utilise le router dynamic get
             */
        } elseif (count($_GET) !== 0) {
            /**
             * si get ne contien qu'un paramétre alors on vérifie si une class
             * ou méthode correspond
             * si une class correspond alors on l'instencie à la methode IndexAction
             * sinon si une méthode correspond dans AppController alors on l'instencie avec cette methode
             * sinon 404
             */
            if (count($_GET) === 1) {
                if (class_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"))) {
                    $class_name = ucfirst($_GET["c"]) . "Controller";
                    $method = "IndexAction";
                } elseif (method_exists($namespace . "\\" . "AppController", $_GET["a"] . "Action")) {
                    $class_name = "AppController";
                    $method = $_GET["a"] . "Action";
                } else {
                    header('Location: http://localhost/PiePHP/404');
                }
                /**
                 * si dans le get une class et une methode existe alors on creer la route
                 * sinon 404
                 */
            } elseif (count($_GET) === 2) {
                if (
                    class_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"))
                    && method_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"), $_GET["a"] . "Action")
                ) {
                    $class_name = ucfirst($_GET["c"] . "Controller");
                    $method = ucfirst($_GET["a"] . "Action");
                } else {
                    header('Location: http://localhost/PiePHP/404');
                }
            }
            /**
             * Sinon on utilise le router dynamique
             */
        } else {
            /**
             * on explode l'url avec les "/"
             * puis on retire les partie du tableau vide
             */
            $array = explode("/", $url);
            array_shift($array);
            for ($i = 0; $i < count($array); $i++) {
                if (in_array($array[$i], $array) && $array[$i] === "") {
                    unset($array[$i]);
                }
            }
            /**
             * si l'url contien deux paramétres alors on vérifie si une class
             * et méthode correspond
             * si une class correspond alors on l'instencie à la methode donnée
             * sinon 404
             */
            if (count($array) === 2) {
                if (
                    class_exists($namespace . "\\" . ucfirst($array[0] . "Controller"))
                    && method_exists($namespace . "\\" . ucfirst($array[0] . "Controller"), $array[1] . "Action")
                ) {
                    $class_name = ucfirst($array[0] . "Controller");
                    $method = ucfirst($array[1] . "Action");
                } else {
                    header('Location: http://localhost/PiePHP/404');
                }
                /**
                 * si l'url ne contien qu'un paramétre alors on vérifie si une class
                 * ou méthode correspond
                 * si une class correspond alors on l'instencie à la methode IndexAction
                 * si une méthode correspond dans AppController alors on l'instencie avec cette methode
                 * sinon 404
                 */
            } elseif (count($array) === 1) {
                if (class_exists($namespace . "\\" . ucfirst($array[0] . "Controller"))) {
                    $class_name = ucfirst($array[0]) . "Controller";
                    $method = "IndexAction";
                } elseif (method_exists($namespace . "\\" . "AppController", $array[0] . "Action")) {
                    $class_name = "AppController";
                    $method = $array[0] . "Action";
                } else {
                    header('Location: http://localhost/PiePHP/404');
                }
            } else {
                header('Location: http://localhost/PiePHP/404');
            }
        }
        /**
         * on instencie la class
         * et la methode demmander
         */
        $class = "$namespace\\$class_name";
        $controller = new $class();
        $controller->$method();
    }

    public function runDynamicUrl($url)
    {
        /**
         * Router Hybride
         * on defini le namespace pour les verification
         */
        $namespace = "\\src\\Controller";
        /**
         * on explode l'url avec les "/"
         * puis on retire les partie du tableau vide
         */
        $array = explode("/", $url);
        array_shift($array);
        for ($i = 0; $i < count($array); $i++) {
            if (in_array($array[$i], $array) && $array[$i] === "") {
                unset($array[$i]);
            }
        }
        /**
         * si l'url contien deux paramétres alors on vérifie si une class
         * et méthode correspond
         * si une class correspond alors on l'instencie à la methode donnée
         * sinon 404
         */
        if (count($array) === 2) {
            if (
                class_exists($namespace . "\\" . ucfirst($array[0] . "Controller"))
                && method_exists($namespace . "\\" . ucfirst($array[0] . "Controller"), $array[1] . "Action")
            ) {
                $class_name = ucfirst($array[0] . "Controller");
                $method = ucfirst($array[1] . "Action");
            } else {
                header('Location: http://localhost/PiePHP/404');
            }
            /**
             * si l'url ne contien qu'un paramétre alors on vérifie si une class
             * ou méthode correspond
             * si une class correspond alors on l'instencie à la methode IndexAction
             * si une méthode correspond dans AppController alors on l'instencie avec cette methode
             * sinon 404
             */
        } elseif (count($array) === 1) {
            if (class_exists($namespace . "\\" . ucfirst($array[0] . "Controller"))) {
                $class_name = ucfirst($array[0]) . "Controller";
                $method = "IndexAction";
            } elseif (method_exists($namespace . "\\" . "AppController", $array[0] . "Action")) {
                $class_name = "AppController";
                $method = $array[0] . "Action";
            } else {
                header('Location: http://localhost/PiePHP/404');
            }
            /**
             * si l'url ne contien aucun paramétre alors on redirige sur 
             * AppController/IndexAction
             * sinon 404
             */
        } elseif (count($array) === 0) {
            $class_name = "AppController";
            $method = "IndexAction";
        } else {
            header('Location: http://localhost/PiePHP/404');
        }
        /**
         * on instencie la class
         * et la methode demmander
         */
        $class = "$namespace\\$class_name";
        $controller = new $class();
        $controller->$method();
    }

    public function runDynamicGet()
    {
        /**
         * Router Dynamic get
         * on defini le namespace pour les verification
         */
        $namespace = "\\src\\Controller";
        /**
         * si get ne contien qu'un paramétre alors on vérifie si une class
         * ou méthode correspond
         * si une class correspond alors on l'instencie à la methode IndexAction
         * sinon si une méthode correspond dans AppController alors on l'instencie avec cette methode
         * sinon 404
         */
        if (count($_GET) === 1) {
            if (class_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"))) {
                $class_name = ucfirst($_GET["c"]) . "Controller";
                $method = "IndexAction";
            } elseif (method_exists($namespace . "\\" . "AppController", $_GET["a"] . "Action")) {
                $class_name = "AppController";
                $method = $_GET["a"] . "Action";
            } else {
                header('Location: http://localhost/PiePHP/404');
            }
            /**
             * si dans le get une class et une methode existe alors on creer la route
             * sinon 404
             */
        } elseif (count($_GET) === 2) {
            if (
                class_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"))
                && method_exists($namespace . "\\" . ucfirst($_GET["c"] . "Controller"), $_GET["a"] . "Action")
            ) {
                $class_name = ucfirst($_GET["c"] . "Controller");
                $method = ucfirst($_GET["a"] . "Action");
            } else {
                header('Location: http://localhost/PiePHP/404');
            }
        } else {
            header('Location: http://localhost/PiePHP/404');
        }
        /**
         * on instencie le controller et sa methode associer
         */
        $class = "$namespace\\$class_name";
        $controller = new $class();
        $controller->$method();
    }
}
