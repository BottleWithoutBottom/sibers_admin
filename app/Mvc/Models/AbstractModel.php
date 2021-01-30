<?php

namespace App\Mvc\Models;
use App\Core\QueryBuilder\PdoQueryBuilder;
abstract class AbstractModel {
    protected $queryBuilder;

    public function __construct() {
        $this->setQueryBuilder(new PdoQueryBuilder());
    }

    protected function setQueryBuilder($queryBuilder) {
        $this->queryBuilder = $queryBuilder;
    }
    protected function getQueryBuilder() {
        return $this->queryBuilder;
    }

}