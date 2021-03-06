<?php

namespace App\Mvc\Views;

class View {
    const HEADER = 'header';
    const FOOTER = 'footer';

    protected $name;
    protected $template;

    public function __construct($viewName) {
        $this->setName($viewName);
        $name = $this->getName();
        $this->setTemplate($name);
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
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    public function render($title, $params = [], $page = '') {
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

    public static function Show404() {
        http_response_code(400);

        require VIEWS_DIR . 'Error404Controller.php';
    }
}