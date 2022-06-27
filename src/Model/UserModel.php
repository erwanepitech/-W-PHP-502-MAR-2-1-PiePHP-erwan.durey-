<?php

namespace src\Model;

class UserModel extends \Core\Entity
{

    public $table = "Users";
    private $data = [];
    private $data_table = [];
    public $id;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v) {
            if ($k === "password") {
                $this->data[$k] = password_hash($v, PASSWORD_DEFAULT);
            } elseif ($k === "password_user") {
                $this->$k = $v;
            } elseif ($k === "new_password") {
                $this->data[$k] = password_hash($v, PASSWORD_DEFAULT);
            } else {
                $this->data[$k] = $v;
            }
        }
        $this->data_table["table"] = $this->table;
        $this->data_table[1] = $this->data;
        parent::__construct($this->data_table);
    }

    public function save()
    {
        $condi = [
            "FIELDS" => "id, email, password",
            "WHERE" => "email = '" . $this->data["email"] . "'",
            "ORDER BY" => "email ASC",
            "LIMIT" => "1"
        ];
        $res = parent::find($condi);
        $count = intval($res);
        if ($count !== 0) {
            return false;
        } else {
            parent::create();
            return true;
        }
    }

    public function login()
    {
        $condi = [
            "FIELDS" => "id, email, password",
            "WHERE" => "email = '" . $this->data["email"] . "'",
            "ORDER BY" => "email ASC",
            "LIMIT" => "1"
        ];
        $res = parent::find($condi);
        if ($res) {
            $this->id = $res[0]["id"];
            $password = $res[0]["password"];
            if (password_verify($this->password_user, $password)) {
                $msg = ["succes" => 1, "id" => $this->id];
            } else {
                $msg = ["succes" => 0];
            }
            return $msg;
        } else {
            return false;
        }
    }

    public function get_info($id)
    {
        return parent::read($id);
    }

    public function Update_info($id)
    {
        $condi = [
            "FIELDS" => "id, email, password",
            "WHERE" => "id = '" . $id . "'",
            "ORDER BY" => "email ASC",
            "LIMIT" => "1"
        ];
        $res = parent::find($condi);
        if ($res) {
            $this->id = $res[0]["id"];
            $password = $res[0]["password"];
            if (password_verify($this->password_user, $password)) {
                if (array_key_exists("new_password", $this->data)) {
                    $fields = [
                        "email" => $this->data["email"],
                        "password" => $this->data["new_password"]
                    ];
                    parent::Update($id, $fields);
                } else {
                    $fields = [
                        "email" => $this->data["email"]
                    ];
                    parent::Update($id, $fields);
                }
                $msg = ["succes" => 1];
            } else {
                $msg = ["succes" => 0];
            }
            return $msg;
        } else {
            return false;
        }
    }

    public function Delete_account($id)
    {
        parent::delete($id);
        $msg = ["succes" => 1];
        return $msg;
    }

    public function Read_all($id)
    {
        $condi = [
            "WHERE" => "id = " . $id,
            "ORDER BY" => "id ASC",
            "LIMIT" => "10"
        ];
        return parent::find($condi);
    }
}
