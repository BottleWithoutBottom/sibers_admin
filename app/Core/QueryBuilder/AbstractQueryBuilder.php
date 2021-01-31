<?php

namespace App\Core\QueryBuilder;

abstract class AbstractQueryBuilder {
    protected $driver;
    protected $errors = [];
    protected $results;

    abstract protected function catchErrors();

    public function getResults($index = null) {
        return empty($index) ? $this->results[$index] : $this->results;
    }

    protected function getErrors() {
        return $this->errors;
    }

    protected function setError($error) {
        $this->errors[] = $error;
    }


    protected function getDriver() {
        return $this->driver;
    }

    protected function setDriver($driver) {
        $this->driver = $driver;
    }
}