<?php
namespace App\Core;
use PDO;
class DBDriver {
    protected static $instance;
    protected $PDO;

    private function __construct() {
        $config = $this->getConfig();
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

    public static function getInstance() {
        if (!isset(static::$instance)) return new static();

        return static::$instance;
    }

    public function getPdo() {
        return $this->PDO;
    }

    private function getConfig() {
        return require(CONFIGS . 'database.php');
    }
}