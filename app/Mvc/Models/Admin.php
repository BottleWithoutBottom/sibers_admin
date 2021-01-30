<?php

namespace App\Mvc\Models;

class Admin extends AbstractModel {

    public function getUsers() {
        return $this->getQueryBuilder()->select('users')->getResults();
    }

    public function getUser($id) {
        return $this->getQueryBuilder()->select('users', ['id', '=', $id])->getResults(0);
    }
}