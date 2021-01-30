<?php

namespace App\Mvc\Controllers;
use App\Mvc\Views\View;

abstract class AbstractController {
    protected $route;
    protected $model;
    protected $view;

    public function __construct($route) {
        $this->setRoute($route);
        $this->attachView($route);
        $this->model = $this->attachModel($this->getRoute()['controller']);
    }

    /**
     * @return mixed
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route): void {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void {
        $this->model = $model;
    }

    protected function attachModel($controller) {
        $modelName =  preg_replace('#Controller#', '', $controller);
        $model = MODELS_NAMESPACE . $modelName;
        if (class_exists($model)) {
            return new $model($this->getRoute());
        } else {
            throw new Exception('model was not found');
        }
    }

    protected function attachView($route) {
        if (!$route['controller'] || !$route['action']) return false;
        $viewName = $route['controller'] . ucfirst($route['action']);
        $this->view = new View($viewName);
        return true;
    }


}