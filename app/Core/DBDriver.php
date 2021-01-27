<?php
namespace App\Core;
use PDO;
class DBDriver {
    protected static $instance;
    protected $PDO;

    private function __construct($config) {
        try {
            $this->PDO = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';',
                $config['user'],
                $config['password']
            );
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance($config) {
        if (!isset(static::$instance)) return new static($config);

        return static::$instance;
    }
}