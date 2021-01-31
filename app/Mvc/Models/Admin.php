<?php

namespace App\Mvc\Models;
use App\Mvc\Models\User;

class Admin extends AbstractModel {

    public function getUsers($limit = []) {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [], [], $limit)->getResults();
    }

    public function getUser($id) {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [User::ID, '=', $id])->getResults(0);
    }

    public function getUsersCount() {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [], [User::ID])->count();
    }
}