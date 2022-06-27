<?php

namespace Core;

class ORM
{

    private $host;
    private $username;
    private $password;
    private $db;
    private $cfg;

    protected $connection;

    /**
     * function __construct
     *
     * @return $this->connection connexion à la base de donées
     */
    public function __construct()
    {
        $this->cfg = json_decode(file_get_contents("config.json"));
        $this->host = $this->cfg->{"connect"}->{"host"};
        $this->username = $this->cfg->{"connect"}->{"username"};
        $this->password = $this->cfg->{"connect"}->{"password"};
        $this->db = $this->cfg->{"connect"}->{"database"};
        /**
         * Initialisation de la connexion à la base de données
         */
        try {
            $this->connection = new \PDO("mysql:host=" . $this->host .
                ";dbname=" . $this->db . "", "'$this->username'", "$this->password");
            $this->connection->exec('SET NAMES "UTF8"');
        } catch (\PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * function create
     *
     * @param  string $table nom de la table en base de données
     * @param  mixed $fields champs où inséré les données
     * @return void
     */
    public function create($table, $fields)
    {
        try {
            $sql = "INSERT INTO $table (";
            foreach ($fields as $k => $v) {
                $sql .= "$k, ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";

            foreach ($fields as $k => $v) {
                $sql .= ":$k, ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ");";
            $bV = $this->connection->prepare($sql);
            foreach ($fields as $k => $v) {
                $bV->bindValue($k, $v, \PDO::PARAM_STR);
            }
            $bV->execute();
            $id = $this->connection->lastInsertId();
            // echo $id . " [OK] " . PHP_EOL;
            // var_dump($id);
            if (isset($id)) {
                return $id;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * function read
     *
     * @param  string $table nom de la table en base de données
     * @param  int $id id de l'objet ou récupérer les information
     * @return $res tableau du resultats de la requete
     */
    public function read($table, $id)
    {
        try {
            $sql = "SELECT *
            FROM $table
            WHERE id = :id";
            $bV = $this->connection->prepare($sql);
            $bV->bindValue('id', $id, \PDO::PARAM_INT);
            $bV->execute();
            $res = $bV->fetch(\PDO::FETCH_ASSOC);
            return $res;
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * function update
     *
     * @param  string $table nom de la table en base de données
     * @param  int $id id de l'objet a supprimer
     * @param  mixed $fields champs à modifier
     * @return void
     */
    public function update($table, $id, $fields)
    {
        try {
            $sql = "UPDATE $table SET ";
            foreach ($fields as $k => $v) {
                if ($k !== "id") {
                    $sql .= "$k = :$k, ";
                }
            }
            $sql = substr($sql, 0, -2);
            $sql .= " WHERE id = :id";
            $bV = $this->connection->prepare($sql);
            $bV->bindValue(':id', "$id", \PDO::PARAM_INT);
            foreach ($fields as $k => $v) {
                $bV->bindValue(":$k", "$v", \PDO::PARAM_STR);
            }
            $bV->execute();
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * function delete
     *
     * @param  string $table nom de la table en base de données
     * @param  int $id id de l'objet a supprimer
     * @return void
     */
    public function delete(string $table, int $id)
    {
        var_dump($table);
        var_dump($id);
        try {
            $sql = "DELETE
            FROM $table
            WHERE id = :id";
            $bV = $this->connection->prepare($sql);
            $bV->bindValue(':id', $id, \PDO::PARAM_INT);
            $bV->execute();
            echo "<pre>";
            echo $sql . PHP_EOL;
            echo "</pre>";
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * function find
     *
     * @param  string $table nom de la table en base de données
     * @param  array $params paramétres de la requete
     * @param  string $relations relation du model par rapport à un autres
     * @return $res tableau du resultats de la requete
     */
    public function find(string $table, $params)
    {
        try {
            if (array_key_exists("FIELDS", $params)) {
                $fields = $params["FIELDS"];
            } else {
                $fields = "*";
            }
            $sql = "SELECT $fields
            FROM $table ";
            if (array_key_exists("INNER JOIN", $params)) {
                $sql .= $params["INNER JOIN"];
            }
            if (array_key_exists("WHERE", $params)) {
                $sql .= " WHERE " . $params["WHERE"];
            }
            if (array_key_exists("ORDER BY", $params)) {
                $sql .= " ORDER BY " . $params["ORDER BY"];
            }
            if (array_key_exists("LIMIT", $params)) {
                $sql .= " LIMIT " . $params["LIMIT"];
            }
            if (array_key_exists("GROUP BY", $params)) {
                $sql .= " GROUP BY " . $params["GROUP BY"];
            }
            $bV = $this->connection->prepare($sql);
            $bV->execute();
            // if (array_key_exists("FIELDS", $params) && (array_key_exists("has one", $relations) || array_key_exists("has many", $relations)) && array_key_exists("INNER JOIN", $params) && count($relations) !== 0 ) {
            //     $res = $bV->fetch(\PDO::FETCH_ASSOC);
            // } else {
            // echo "<pre>";
            // echo $sql . PHP_EOL;
            $res = $bV->fetchAll(\PDO::FETCH_ASSOC);
            // }
            // var_dump($res);
            // print_r($params);
            // echo "<pre>";
            // echo $sql . PHP_EOL;
            // echo "</pre>";
            if ($res) {
                return $res;
            } else {
                return false;
                // echo "<pre>";
                // echo($sql);
                // echo "</pre>";
            }
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
