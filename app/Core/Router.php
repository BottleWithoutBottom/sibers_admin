<?php
namespace App\Core;

use mysql_xdevapi\Exception;

class Router {
    const CHILDREN = 'CHILDREN';

    protected static $instance;
    protected $routes;
    protected $config;
    protected $params;

    private function __construct() {
        $this->config = $this->loadConfigfile();
    }

    public static function getInstance() {
        if (empty(static::$instance)) return new self();

        return static::$instance;
    }

    public function loadConfigfile() {
        return require($_SERVER['DOCUMENT_ROOT'] . 'app/config/bootstrap.php');
    }

    public function generateRoutes() {
        if (empty($this->config)) return false;

        foreach ($this->config as $route => $params) {
            $this->addRoute($route, $params);
        }

    }

    public function execute() {
        if (!$this->mount()) throw new \Exception('UNKNOWN ROUTE PATH');

        $controllerPath = $_SERVER['DOCUMENT_ROOT'] . 'app/mvc/controllers/' . $this->params['controller'];

        if (class_exists($controllerPath)) {
            $action = $this->params['action'];

            if (method_exists($controllerPath, $action)) {
                $controller = new $controllerPath($this->params);
                $controller->$action();
            }
        }

        return false;
    }

    protected function addRoute($route, $params) {
        if (!$route || !$params) return false;

        $route_preg = $this->pregRoute($route);

        $this->setRouteParams($route_preg, $params);
        $children = $params[static::CHILDREN];
        if (!empty($children)) {
            foreach ($children as $child => $childParams) {
                $this->add($child, $childParams);
            }
        }

        return true;
    }

    protected function mount() {
        foreach($this->routes as $route => $params) {
            if (preg_match($route, $_SERVER['REQUEST_URI'])) {
                $this->setParams($params);
                return true;
            }
        }
    }

    protected function pregRoute($route) {
        if (empty($route)) return false;

        return '#^' . $route . '$#';
    }

    protected function setRouteParams($route_preg, $params) {
        $this->routes[$route_preg] = $params;

        return true;
    }

    protected function setParams($params) {
        $this->params = $params;
    }
}