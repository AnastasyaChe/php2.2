<?php


namespace app\models\repositories;


use app\models\Record;
use app\services\Db;

abstract class Repository
{
    protected $db;
    protected $tableName;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = $this->getTableName();
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return  $this->getQuery($sql,[]);
    }

    public function getById(int $id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return  $this->getQuery($sql, [':id' => $id])[0];
    }
    public function getByIds (array $productIds) {
        $table = $this->getTableName();
        $where = implode(', ', $productIds);
        $sql = "SELECT * FROM {$table} WHERE id IN ({$where})";
        return $this->getQuery($sql);
    }

    public function delete(Record $record)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $record->id]);
    }

    public function insert(Record $record)
    {
        $tableName = $this->getTableName();

        $params = [];
        $columns = [];

        foreach ($record as $key => $value) {
            if(in_array($key,['db', 'tableName'])) {
                continue;
            }

            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
        }

        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));

        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $this->id = $this->db->getLastInsertId();
    }


    public function update(Record $record)
    {
        $tableName = $this->getTableName();
        $basketData = [];
        $basketData = $_SESSION['basket'];
        $arrayData = array($this);
        $newArray = array_diff_assoc($basketData, $arrayData);
        if(isset($newArray)) {
            $params = [];
            $columns = [];
            $updateFields = [];

        foreach ($newArray as $key => $value) {
            
            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
            $updateFields[] = "{$key} = {$value}";
        }

        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));
        $updateFields = implode(",", $updateFields);


        $sql = "UPDATE {$tableName} ({$updateFields}) WHERE id = :id";
        $this->db->execute($sql, [':id' => $this->id]);
        
    }
        
    }

    public function save(Record $record)
    {
        if(is_null($record->id)) {
            $this->insert($record);
        }else {
            $this->update($record);
        }
    }

    protected function getQuery($sql, $params = []) {
        return Db::getInstance()->queryAll($sql,$params, $this->getRecordClassname());
    }

    abstract public function getTableName(): string;

    abstract public function getRecordClassname(): string;

}