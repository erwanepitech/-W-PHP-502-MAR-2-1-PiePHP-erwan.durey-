<?php

namespace src\Model;

class TagsModel extends \Core\Entity
{

    public $table = "Tags";
    public $jointure = "Articles_tags";
    private $data_table = [];
    private static $relations = [];

    public function __construct()
    {
        self::$relations = ["has many" => "Articles"];
        $this->data_table["table"] = $this->table;
        $this->data_table["jointure"] = $this->jointure;
        parent::__construct($this->data_table);
        parent::set_relation(self::$relations);
    }
}