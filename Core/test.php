<?php
protected function find(array $condi = [])
{
    // var_dump($this->jointure);
    $namespace = "\\src\\Model";
    $classname = $this->relations["has many"];
    $join = "$namespace\\$classname" . "Model";
    $model = new $join();
    if (array_key_exists("has many", $this->relations) && $model->relations["has many"] !== $this->relations["has many"] && !isset($this->jointure)) {
        $condi["INNER JOIN"] = "INNER JOIN " . $this->relations["has many"] . " ON " . $this->relations["has many"] . ".id_" . $this->table . " = " . $this->table . ".id";
        $this->result[$this->table] = $this->ORM->find($this->table, $condi);
        // $method = "get_" . $classname;
        // $res = $model->$method();

        echo "<pre>";
        echo "result :" . PHP_EOL;
        var_dump($model->jointure);
        var_dump(isset($model->jointure));
        // var_dump($res);
        var_dump($model->relations);
        var_dump($this->result);
        echo "</pre>";
        // return $this->result[$this->relations["has many"]];
    }
    if (array_key_exists("has many", $this->relations) && array_key_exists("has many", $model->relations) && isset($model->jointure)) {
        $namespace = "\\src\\Model";
        $classname = $this->relations["has many"];
        $condi["INNER JOIN"] = "INNER JOIN " . $model->jointure . " ON " . $model->jointure . ".id_" . $this->table . " = " . $this->table . ".id
        INNER JOIN " . $this->relations["has many"] . " ON " . $model->jointure . ".id_" . $this->relations["has many"] . " = " . $this->relations["has many"] . ".id";
        $this->result[$this->relations["has many"]] = $this->ORM->find($this->table, $condi);
        // $join = "$namespace\\$classname" . "Model";
        // $model = new $join();
        $method = "get_" . $classname;
        $res = $model->$method();
        echo "<pre>";
        echo "result :" . PHP_EOL;
        var_dump($model->jointure);
        var_dump(isset($model->jointure));
        var_dump($res);
        // var_dump($this->relations);
        var_dump($this->result[$this->relations["has many"]]);
        echo "</pre>";
        return $this->result[$this->relation["has many"]];
    } else {
        return $this->ORM->find($this->table, $condi);
    }
}