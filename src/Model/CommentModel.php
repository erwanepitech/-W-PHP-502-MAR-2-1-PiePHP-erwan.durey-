<?php

namespace src\Model;

class CommentModel extends \Core\Entity
{

    public $table = "Comments";
    private $data = [];
    private $data_table = [];
    public $jointure = "";
    public $id;
    private static $relations;


    public function __construct()
    {
        self::$relations = ["has one" => "Articles"];
        $this->data_table["table"] = $this->table;
        $this->data_table["relation"] = self::$relations;
        $this->data_table[1] = $this->data;
        $this->data_table["jointure"] = $this->jointure;
        parent::set_relation(self::$relations);
        parent::__construct($this->data_table);
    }

    public function save()
    {
        if (parent::create() !== false) {
            $this->id = parent::create();
            return $this->id;
        }
    }

    public function get_comments()
    {
        $condi = [
            "FIELDS" => 'Comments.content AS "commentaire", Comments.date AS "date_comment"',
        ];
        $res = parent::find($condi);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public function get_info()
    {
        $id = $this->data["id"];
        // return parent::read($id);
        return parent::read(2);
    }

    public function Update_info()
    {
        $id = $this->data["id"];
        $fields = [];
        return parent::Update($id, $fields);
    }

    public function Delete_account()
    {
        $id = $this->data["id"];
        return parent::delete($id);
    }

    public function Read_all()
    {
        $condi = [
            "WHERE" => "id = 1",
            "ORDER BY" => "id ASC",
            "LIMIT" => "10"
        ];
        return parent::find($condi);
    }
}
