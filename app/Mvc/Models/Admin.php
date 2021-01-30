<?php

namespace App\Mvc\Models;

class Admin extends AbstractModel {

    public function getUsers() {
        $users = $this->getQueryBuilder()->select('users')->getResults();
        return $users;
    }
}