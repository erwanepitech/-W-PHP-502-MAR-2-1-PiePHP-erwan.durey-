<?php

namespace src\Model;

class ArticlesModel extends \Core\Entity
{

    public $table = "Articles";
    private $data_table = [];
    public $id;
    private static $relations = [];

    public function __construct()
    {
        self::$relations = [
            "has many" => "Comments",
            // "has many" => "Tags"
        ];
        $this->data_table["table"] = $this->table;
        parent::__construct($this->data_table);
        parent::set_relation(self::$relations);
    }

    public function get_article()
    {
        $res = parent::find();
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
}