<?php

namespace App\Mvc\Views;

class View {
    const HEADER = 'header';
    const FOOTER = 'footer';

    protected $route;
    protected $template;

    public function __construct($route) {
        $this->setRoute($route);
        $route = $this->getRoute();
        $this->setTemplate($route['controller']);
    }

    /**
     * @return mixed
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template): void {
        $this->template = $template;
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

    public function render($title, $params = []) {
        $header = LAYOUTS . static::HEADER . '.php';
        $footer = LAYOUTS . static::FOOTER . '.php';
        if (!file_exists($header) || !file_exists($footer)) throw new \Exception('footer or header was not found!');
        if (!empty($params)) extract($params);
        ob_start();
        require (VIEWS_DIR . $this->template . '.php');

        $content = ob_get_clean();
        require $header;
        require $footer;
    }
}