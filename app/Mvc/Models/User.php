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

    /** @param array limit ['firstRow'=>number, 'lastRow'=>number] */
    public function getUser($key, $operand, $value, $selectFields = [], $limit = []) {
        if (empty($key) && empty($operand) && empty($value)) return false;

        return $this->queryBuilder->select(static::TABLE_NAME, [$key, $operand, $value], $selectFields, $limit)->getResults(0);
    }

    public function setUser($fields) {
        if (empty($fields[static::LOGIN]) || empty($fields[static::PASSWORD])) return false;
        return $this->queryBuilder->insert(static::TABLE_NAME, $fields);
    }

    public function deleteUser($userId) {
        if (empty($userId)) return false;

        return $this->queryBuilder->delete(static::TABLE_NAME, [static::ID, '=', $userId]);
    }

    public function updateUser($fields) {
        if (empty($fields[static::ID])) var_dump('Cannot refresh user\'s data without passing an id');


        return $this->queryBuilder->update(static::TABLE_NAME, $fields, [static::ID, '=', $fields[static::ID]]);
    }

}