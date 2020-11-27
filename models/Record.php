<?php
namespace app\models;

use app\interfaces\ModelInterface;
use app\services\Db;

abstract class Record implements ModelInterface
{
    
    protected $db;
    protected $tableName;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = static::getTableName();
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return  static::getQuery($sql,[]);
    }

    public static function getAllProducts(array $ids = [])
    {
        $tableName = static::getTableName();
        $where = '';
            if(!empty($ids)) {
                $in = implode(', ', $ids);
                $where = "WHERE id IN ($in)";
            }
            return static::getQuery("SELECT * FROM {$tableName} {$where}");
       
    }

    public static function getById(int $id) {
       $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return  static::getQuery($sql, [':id' => $id])[0];
    }

    public function delete()
    {
        $sql = "DELETE * FROM {$this->tableName} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $this->id]);
    }

    public function update()
    {
        $tableName = static::getTableName();
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


    public function insert()
    {
        $tableName = static::getTableName();

        $params = [];
        $columns = [];

        foreach ($this as $key => $value) {
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

    public function save() {
        if(is_null($this->id)) {
            $this->insert();
        }else {
            $this->update();
        }
    }

    protected static function getQuery($sql, $params = []) {
        return Db::getInstance()->queryAll($sql,$params, get_called_class());
    }
    
}