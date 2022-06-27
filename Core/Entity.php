<?php

namespace Core;

/**
 * abstract class Entity
 * 
 * abstrait tout les appels à l'ORM
 */
abstract class Entity
{

    private $ORM;
    private $table;
    private $data;
    private $jointure;
    private $relations = [];
    private $result = [];

    /**
     * function __construct Entity
     *
     * Instancie la class ORM pour effectuer les requêtes 
     * @param  array $data tableau contenant tout les attribus du model
     * @return void
     */
    public function __construct(array $data)
    {
        $this->ORM = new ORM();
        $this->table = $data["table"];
        if (array_key_exists("jointure", $data)) {
            $this->jointure = $data["jointure"];
        }
        $this->data = $data[1];
        // echo "<pre>";
        // var_dump($data);
        // var_dump(array_key_exists("jointure", $data));
        // var_dump($this->jointure);
        // echo "</pre>";
    }

    /**
     * function set_relation
     *
     * en fonction de la relation attribuer modifie la requête pour obtenir les information lier aux deux modèles
     * @param  array $relation tableau contenant la relation de model
     * @return $relation le tableau contenant la relation de model
     */
    protected function set_relation($relation)
    {
        // echo "<pre>";
        // var_dump($relation);
        // echo "</pre>";
        $this->relations = $relation;
    }

    /**
     * function create
     * 
     * @return instantiation de la methode create de l'orm
     */
    protected function create()
    {
        return $this->id = $this->ORM->create($this->table, $this->data);
    }

    /**
     * function read
     *
     * @param  int $id id de l'objet ou récupérer les information
     * 
     * @return instantiation de la methode read de l'orm
     */
    protected function read(int $id)
    {
        return $this->ORM->read($this->table, $id);
    }

    /**
     * function update
     * @param int $id id de l'objet à mettre à jour
     * @param array $fields champ à mettre à jour
     * 
     * @return instantiation de la methode update de l'orm
     */
    protected function update(int $id, array $fields)
    {
        return $this->ORM->update($this->table, $id, $fields);
    }

    /**
     * function delete
     *
     * @param  int $id id de l'objet à supprimer
     * @return instantiation de la methode delete de l'orm
     */
    protected function delete(int $id)
    {
        return $this->ORM->delete($this->table, $id);
    }

    /**
     * function find
     *
     * @param  array $condi tableau contenant les conditions de la reqête
     * @return instantiation de la methode find de l'orm
     */
    protected function find(array $condi = [])
    {
        if (count($this->relations) !== 0) {
            $namespace = "\\src\\Model";
            $classname = $this->relations["has many"];
            $class = "$namespace\\$classname" . "Model";
            $model = new $class();
            if (array_key_exists("has one", $model->relations)) {
                $this->result[$this->table] = $this->ORM->find($this->table, $condi);
                for ($i = 0; $i < count($this->result[$this->table]); $i++) {
                    $condi = [
                        "WHERE" => 'id_' . $this->table . ' = ' . $this->result[$this->table][$i]["id"]
                    ];
                    $this->result[$this->table][$i][$this->relations["has many"]] = $this->ORM->find($this->relations["has many"], $condi);
                }
                // echo "<pre>";
                // var_dump($this->result);
                // var_dump($this->relations["has many"]);
                // echo "</pre>";
                return $this->result;
            } elseif (array_key_exists("has many", $this->relations) && array_key_exists("has many", $model->relations) && !array_key_exists("has one", $model->relations)) {
                $this->result[$this->table] = $this->ORM->find($this->table, $condi);
                for ($i = 0; $i < count($this->result[$this->table]); $i++) {
                    $condi = [
                        "INNER JOIN" => "
                            INNER JOIN " . $this->table . "_" . $this->relations["has many"] . " ON " . $this->table . "_" . $this->relations["has many"] . ".id_" . $this->table . " = " . $this->table . ".id
                            INNER JOIN " . $this->relations["has many"] . " ON " . $this->table . "_" . $this->relations["has many"] . ".id_" . $this->relations["has many"] . " = " . $this->relations["has many"] . ".id",
                        "WHERE" => 'id_' . $this->table . ' = ' . $this->result[$this->table][$i]["id"]
                    ];
                    $this->result[$this->table][$i][$this->relations["has many"]] = $this->ORM->find($this->table, $condi);
                }
                // echo "<pre>";
                // var_dump($this->result);
                // var_dump($this->relations["has many"]);
                // var_dump($this->table);
                // var_dump($model->table);
                // var_dump($this->result);
                // echo "</pre>";
                return $this->result;
            } else {
                return $this->ORM->find($this->table, $condi);
            }
        } else {
            return $this->ORM->find($this->table, $condi);
        }
    }
}
