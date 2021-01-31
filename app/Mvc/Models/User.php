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

    public CONST AUTHORIZED_STATUS = 1;
    public CONST CONFIRMED_STATUS = 2;
    public CONST GOD_STATUS = 3;

    public function getUser($key, $operand, $value, $selectFields = []) {
        if (empty($key) && empty($operand) && empty($value)) return false;

        return $this->queryBuilder->select(static::TABLE_NAME, [$key, $operand, $value], $selectFields)->getResults(0);
    }

    public function setUser($fields) {
        if (empty($fields[static::LOGIN]) || empty($fields[static::PASSWORD])) return false;
        return $this->queryBuilder->insert(static::TABLE_NAME, $fields);
    }

    public function deleteUser($userId) {
        if (empty($userId)) return false;

        return $this->queryBuilder->delete(static::TABLE_NAME, [static::ID, '=', $userId]);
    }

}