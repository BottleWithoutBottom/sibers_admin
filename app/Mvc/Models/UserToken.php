<?php

namespace App\Mvc\Models;

class UserToken extends AbstractModel {
    public CONST USER_ID = 'user_id';
    public CONST TOKEN = 'token';
    public CONST TABLE_NAME = 'user_session';

    public function selectUserIdByToken($token) {
        if (empty($token)) return false;

        return $this->queryBuilder->select(static::TABLE_NAME, [static::TOKEN , '=', $token])->getResults(0);
    }

    public function insertToken($user_id, $token) {
        if (empty($user_id) || empty($token)) return false;

        $this->queryBuilder->insert(
            static::TABLE_NAME,
            [
                static::USER_ID => $user_id,
                static::TOKEN => $token,
            ]
        );

        return true;
    }

}