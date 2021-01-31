<?php
namespace App\Core;

use Exception;
use App\Mvc\Views\View;

class Router {
    private const CHILDREN = 'children';
    private const OPEN_TAG = '{';
    private const CLOSE_TAG = '}';
    private const VALUE_CLOSE_TAG = '/';
    private const MAX_URI_LENGTH = 400;

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
        return require(CONFIGS . 'bootstrap.php');
    }

    public function generateRoutes() {
        if (empty($this->config)) return false;

        foreach ($this->config as $route => $params) {
            $this->addRoute($route, $params);
        }

        return true;

    }

    public function execute() {
        if (!$this->mount()) throw new \Exception('UNKNOWN ROUTE PATH');
        $controller = CONTROLLER_NAMESPACE . $this->params['controller'];
        if (class_exists($controller)) {
            $action = $this->params['action'];
            if (method_exists($controller, $action)) {
                $controller = new $controller($this->params);
                $controller->$action($this->params['dynamicParams']);
            } else {
                View::Show404();
            }
        } else {
            View::Show404();
        }

        return false;
    }

    protected function addRoute($route, $params) {
        if (!$route || !$params) return false;

        $this->setRouteParams($route, $params);
        $children = $params[static::CHILDREN];
        if (!empty($children)) {
            foreach ($children as $child => $childParams) {
                $this->addRoute($child, $childParams);
            }
        }

        return true;
    }
    /** функция ищет роут, совпадающий с введенным uri */
    protected function mount() {
        foreach($this->routes as $route => $params) {
            $route_preg = $this->pregRoute($route);
            $params['dynamicParams'] = $this->getDynamicParams($route);
            $request = Request::getInstance();
            $uri = $request->getUri();
            if ($params['pattern'] && preg_match($params['pattern'], $uri) || preg_match($route_preg, $uri)) {
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

    /** функция для извлечения динамических параметров из uri по маске роута */
    private function getDynamicParams($route) {
        if (!strpos($route, '{') || strlen($route <= 1)) return false;
        $dynamicParams = [];
        $request = Request::getInstance();
        $uri = $request->getUri();
        for ($i = 0; $i < strlen($route); $i ++) {
            if ($route[$i] == static::OPEN_TAG) {
                $dynamicParam = $this->parseParam($route, $uri, $i);
                $dynamicParams[$dynamicParam['key']] = $dynamicParam['value'];
            }

            if ($i > static::MAX_URI_LENGTH) return false;
        }
        return $dynamicParams;
    }

    private function parseParam($route, $uri, $pos) {
        // Начальная точка для извлечения параметра
        $loopingPos = $pos;
        $keyLength = 0;

        // Ищем конечную точку для извлечения параметра
        $closeTagFound = false;
        while (!$closeTagFound) {
            $loopingPos++;
            $keyLength++;

            if ($route[$loopingPos] == static::CLOSE_TAG) {
                $closeTagFound = true;
            }
        }

        $paramKey = substr($route, $pos + 1, $keyLength - 1);

        //Ищем конечную точку для извлечения значения параметра из URI
        $cutStartPos = $pos - 1;
        $cutLoopingPos = $cutStartPos;

        $valueLength = 0;
        $closeTagValueFound = false;
        while (!$closeTagValueFound) {
            $cutStartPos++;
            $valueLength++;

            if ($uri[$cutStartPos] == static::VALUE_CLOSE_TAG) {
                $closeTagValueFound = true;
            }

            if ($valueLength > static::MAX_URI_LENGTH) return false;
        }

        // Если сразу же нашелся закрывающийся слеш, значит значение длинной в 1 символ
        if ($valueLength == 1) {
            $valueLength = 1;
        } else {
            $valueLength = $valueLength - 1;
        }
        $paramValue = substr($uri, $cutLoopingPos + 1, $valueLength);
        return [
            'key' => $paramKey ,
            'value' => $paramValue
        ];
    }
}