<?php

namespace App\Mvc\Models;

class User extends AbstractModel {

    public CONST ID = 'id';
    public CONST LOGIN = 'login';
    public CONST PASSWORD = 'password';
    public CONST FIRSTNAME = 'firstname';
    public CONST LASTNAME = 'lastname';
    public CONST STATUS = 'status';
    public CONST TABLE_NAME = 'users';

    public function getUser($key, $operand, $value, $selectFields = []) {
        if (empty($key) && empty($operand) && empty($value)) return false;

        return $this->queryBuilder->select(static::TABLE_NAME, [$key, $operand, $value], $selectFields)->getResults(0);
    }

    public function setUser($fields) {
        if (empty($fields[static::LOGIN]) || empty($fields[static::PASSWORD])) return false;
        return $this->queryBuilder->insert(static::TABLE_NAME, $fields);
    }

}