<?php

namespace App\Mvc\Models;

class Admin extends AbstractModel {

    public function getUsers($limit = [], $sort = []) {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [], [], $limit, $sort)->getResults();
    }

    public function getUser($id) {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [User::ID, '=', $id])->getResults(0);
    }

    public function getUsersCount() {
        return $this->getQueryBuilder()->select(User::TABLE_NAME, [], [User::ID])->count();
    }
}