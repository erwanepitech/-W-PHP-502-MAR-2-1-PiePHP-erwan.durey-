<?php

namespace Core;

class Request
{    
    /**
     * function getQueryParams
     *
     * sécurisaion des entées du formulaires
     * @return array $data_clean 
     */
    public function getQueryParams()
    {
        /**
         * on déclare un tableau vide pour y inséré les données sécurisé
         * on vérifie si la requête est en GET ou POST
         */
        $data_clean = [];
        if (isset($_POST)) {
            $params = $_POST;
        } elseif (isset($_GET)) {
            $params = $_GET;
        }
        /**
         * pour chaque entré du tableau on sécurise les données
         * et on met les données dans le tableau que nous avons déclarer au debut du script
         * puis on retourne ce tableau
         */
        foreach ($params as $k=>$v) {
            $data = htmlspecialchars(strip_tags(stripslashes(trim($v))));
            $data_clean[$k] = $data;
        }
        return $data_clean;
    }
}
