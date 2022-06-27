<?php

namespace src\Controller;

class ArticlesController extends \Core\Controller
{
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

    public function showAction()
    {
        try {
            $article = new \src\Model\ArticlesModel();
            $articles = $article->get_article();
            $post = $articles;
            $this->render("index", $post);
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
