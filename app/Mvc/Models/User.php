<?php

namespace App\Mvc\Models;

class User extends AbstractModel {
    public CONST LOGIN = 'login';
    public CONST PASSWORD = 'password';
    public CONST TABLE_NAME = 'users';

    public function getUser($key, $operand, $value) {
        if (empty($key) && empty($operand) && empty($value)) return false;

        return $this->queryBuilder->select(static::TABLE_NAME, [$key, $operand, $value])->getResults(0);
    }

}