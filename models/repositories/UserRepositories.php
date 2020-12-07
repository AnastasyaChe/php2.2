<?php


namespace app\models\repositories;


class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return "users";
    }

    public function getRecordClassname(): string
    {
        return User::class;
    }

    public function getByCategoryId(int $categoryId)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE category_id = :id";
        return $this->getQuery($sql, [':id' => $categoryId]);
    }

    public function getByLogin($login, $password) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE login = :login, password = :password";
        return $this->getQuery($sql, [':login' => $login, ':password' => $password])[0];
    }
}