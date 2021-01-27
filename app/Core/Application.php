<?php
namespace App\Core;
use App\Core\Request;
use App\Core\Router;
use App\Core\DBDriver;

class Application {
    protected static $instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (empty(static::$instance)) return new self();
        return static::$instance;
    }

    public function getRequest() {
        return Request::getInstance();
    }

    public function getRouter() {
        return Router::getInstance();
    }

    public function getDBDriver($config) {
        return DBDriver::getInstance($config);
    }


}