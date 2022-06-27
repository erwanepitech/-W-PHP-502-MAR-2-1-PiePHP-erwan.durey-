<?php

namespace src\Controller;

class UserController extends \Core\Controller
{
    private $cfg;

    public function __construct()
    {
        /**
         * on instencie la class request pour qu'elle soit prête a recevoir des données a tout moment
         */
        $this->request = new \Core\Request();
    }

    public function IndexAction()
    {
        $this->render('index');
    }

    public function AddAction()
    {
        $this->render('register');
    }

    public function LoginAction()
    {
        $this->render('login');
    }

    public function EditAction()
    {
        if (isset($_SESSION["user"])) {
            $params = $this->request->getQueryParams();
            $user = new \src\Model\UserModel($params);
            $profile = $user->get_info($_SESSION["user"]);
            $this->render('edit', $profile);
        } else {
            header('Location: http://localhost/PiePHP/login');
        }
    }

    public function ConnectAction()
    {
        $params = $this->request->getQueryParams();
        $user = new \src\Model\UserModel($params);
        $login = $user->login();
        if ($login["succes"] === 1) {
            $_SESSION["user"] = $login["id"];
            header('Location: http://localhost/PiePHP/user/profile');
        } elseif ($login["succes"] === 0) {
            $msg = ["error" => "le mot de passe est invalide !"];
            $this->render('login', $msg);
            header('Location: http://localhost/PiePHP/login');
        } else {
            $msg = ["error" => "aucun compte avec cette adresse email"];
            $this->render('login', $msg);
            header('Location: http://localhost/PiePHP/login');
        }
    }

    /**
     * RegisterAction
     *
     * envoie les données a la class request pour qu'elles y soient filtré
     * 
     * et instencie la class UserModel en lui donnant les données filtré
     */
    public function RegisterAction()
    {
        $params = $this->request->getQueryParams();
        $user = new \src\Model\UserModel($params);
        if ($user->save()) {
            header('Location: http://localhost/PiePHP/login');
        } else {
            $msg = ["error" => "Un compe est déja existant avec cette email"];
            $this->render('register', $msg);
        }
    }

    public function showAction()
    {
        if (isset($_SESSION["user"])) {

            $params = $this->request->getQueryParams();
            $user = new \src\Model\UserModel($params);
            $profile = $user->get_info($_SESSION["user"]);
            $this->render('show', $profile);
        } else {
            header('Location: http://localhost/PiePHP/login');
        }
    }

    public function Profile_editAction()
    {
        if (isset($_SESSION["user"])) {

            $params = $this->request->getQueryParams();
            $user = new \src\Model\UserModel($params);
            $profile = $user->Update_info($_SESSION["user"]);
            $this->render('show', $profile);
        } else {
            header('Location: http://localhost/PiePHP/login');
        }
    }

    public function delete_accountAction()
    {
        if (isset($_SESSION["user"])) {
            $params = $this->request->getQueryParams();
            $user = new \src\Model\UserModel($params);
            $profile = $user->Delete_account($_SESSION["user"]);
            if ($profile["succes"] === 1) {
                session_destroy();
                header('Location: http://localhost/PiePHP/register');
            }
        } else {
            header('Location: http://localhost/PiePHP/login');
        }
    }

    public function disconectAction()
    {
        if (isset($_SESSION["user"])) {
            session_destroy();
            header('Location: http://localhost/PiePHP/login');
        } else {
            header('Location: http://localhost/PiePHP/login');
        }
    }
}
