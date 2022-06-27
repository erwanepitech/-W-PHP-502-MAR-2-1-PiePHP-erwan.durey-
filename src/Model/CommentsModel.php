<?php

namespace src\Model;

class CommentsModel extends \Core\Entity
{

    public $table = "Comments";
    private $data_table = [];
    private static $relations;

    public function __construct()
    {
        self::$relations = ["has one" => "Articles"];
        $this->data_table["table"] = $this->table;
        $this->data_table["relation"] = self::$relations;
        parent::set_relation(self::$relations);
        parent::__construct($this->data_table);
    }
}