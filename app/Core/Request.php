<?php

namespace App\Core;

class Request {
    protected static $instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (empty(static::$instance)) return new self();
        return static::$instance;
    }

    public function getQuery($query) {
        return htmlspecialchars(strip_tags($_GET[$query])) ?: null;
    }

    public function getQueryList() {
        return $_GET;
    }

    public function getPost($query) {
        return htmlspecialchars(strip_tags($_POST[$query])) ?: null;
    }

    public function getPostList() {
        return $_POST;
    }

    public function getUri() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getSession($sessionName) {
        return $_SESSION[$sessionName];
    }

    public static function getCookie($cookieName) {
        return $_COOKIE[$cookieName];
    }
}