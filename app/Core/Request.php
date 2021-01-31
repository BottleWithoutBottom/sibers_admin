<?php

namespace App\Core;
use App\Core\Helper;

class Request {
    protected static $instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (empty(static::$instance)) return new self();
        return static::$instance;
    }

    public function getQuery($query) {
        return !empty($_GET[$query]) ? Helper::stripTags($_GET[$query]) : null;
    }

    public function getQueryList() {
        return $_GET;
    }

    public function getPost($query) {
        return !empty($_GET[$query]) ? Helper::stripTags($_POST[$query]) : null;

    }

    public function getPostList() {
        return $_POST;
    }

    public function getUri() {
        return $_SERVER['REQUEST_URI'];
    }

    public function getSession($sessionName) {
        return $_SESSION[$sessionName];
    }

    public function setSession($sessionName, $value) {
        if (empty($sessionName) || empty($value)) return false;

        $_SESSION[$sessionName] = $value;
        return true;
    }

    public function expireSession($sessionName) {
        unset($_SESSION[$sessionName]);
    }

    public function getCookie($cookieName) {
        return $_COOKIE[$cookieName];
    }

    public function setCookie($cookieName, $value, $expire = 3600) {
        if (empty($cookieName) || empty($value)) return false;

        setCookie($cookieName, $value, $expire, '/');
        return true;
    }

    public function expireCookie($cookieName) {
        if (empty($cookieName)) return false;

        setCookie($cookieName, '', time() - 1, '/');
        return true;
    }

    public function getSessionOrCookie($name) {
        $session = $this->getSession($name);
        $cookie = $this->getCookie($name);

        return !empty($session) ? $session : (!empty($cookie) ? $cookie : false);
    }
}