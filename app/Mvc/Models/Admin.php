<?php

namespace App\Mvc\Models;

class Admin extends AbstractModel {

    public function getUsers() {
        return $this->getQueryBuilder()->select('users')->getResults();
    }
}