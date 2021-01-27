<?php
namespace App\Core;

class Router {
    protected static $instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (empty(static::$instance)) return new self();

        return static::$instance;
    }
}