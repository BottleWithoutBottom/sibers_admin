<?php

namespace App\Core\QueryBuilder;
use App\Core\DBDriver;
use PDO;
use Exception;

class PdoQueryBuilder extends AbstractQueryBuilder {
    private CONST OPERATOR_ARRAY_COUNT = 3;
    private CONST AVAILABLE_OPERANDS = ['<', '>', '=', '!=', '<>', '<=', '>='];
    private CONST INIT_BIND_VALUE = 1;

    protected $stmt;


    public function __construct() {
        $this->setDriver(DBDriver::getInstance()->getPdo());
    }

    public function query($sql, $params = []) {
        if (empty($sql)) throw new Exception('query is empty');
        $this->stmt = $this->driver->prepare($sql);
        if (count($params)) {
            $valueCount = static::INIT_BIND_VALUE;

            foreach ($params as $param) {
                $this->stmt->bindValue($valueCount, $param);
                $valueCount++;
            }
        }
        $this->stmt->execute();
        $this->catchErrors();
        $this->results = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this;
    }

    /** Оболочка над методами delete/select,
     * позволяет фильтровать данные,
     * передавая в фильтр ['ключ', 'условие', 'значение']
     */
    public function FROMoperator($tableName, $filter, $operator) {
        if (empty($tableName)) static::emptyTableException();

        $sql = $operator . ' FROM ' . $tableName;
        if (count($filter) === static::OPERATOR_ARRAY_COUNT) {
            $key = $filter[0];
            $operand = $filter[1];
            $value = $filter[2];
            if (in_array($operand, static::AVAILABLE_OPERANDS)) {
                $sql .= ' WHERE ' . $key . ' ' . $operand . ' ?';
                $this->query($sql, [$value]);
            }
        } else {
            $this->query($sql);
        }

        return $this;

    }

    /** @param string $tableName
     * @param array $filter
     * @param array $selectedFields
     * @return AbstractQueryBuilder
     */
    public function select($tableName, $filter = [], $selectedFields = []) {
        if (empty($tableName)) static::emptyTableException();

        $selectedFieldsString = '*';
        if (!empty($selectedFields)) {
            $selectedFieldsString = static::stringify($selectedFields);
        }

        $operator = 'SELECT ' . $selectedFieldsString;

        return $this->FROMoperator($tableName, $filter, $operator);
    }

    public function delete($tableName, $filter) {
        $operator = 'DELETE';

        return $this->FROMoperator($tableName, $filter, $operator);
    }

    /** @param string tableName
     * @param array $fields ['insertKey' => 'insertValue'...]
     * @return AbstractQueryBuilder
     */
    public function insert($tableName, $fields) {
        if (empty($tableName)) static::emptyTableException();
        if (empty($fields)) die('empty fields insert');
        $mask = '';

        foreach($fields as $field) {
            $mask .= '?,';
        }
        $mask = rtrim($mask, ',');

        $sqlKeys = '(`' . implode('`, `', array_keys($fields)) . '`)';
        $sqlValues = '(' . $mask . ')';

        $sql = 'INSERT INTO ' . $tableName . ' ' . $sqlKeys . ' VALUES ' . $sqlValues;
        return $this->query($sql, $fields);
    }

    /** @param string $tableName
     * @param array $fields['updateKey' => 'updateValue']
     * @param array $filter['queryColumn', 'operand', 'queryValue']
     */
    public function update($tableName, $fields, $filter) {
        if (empty($tableName)) static::emptyTableException();

        $mask = '';
        foreach ($fields as $key => $fieldValue) {
            $mask .= ($key . '?,');
        }
        $mask = rtrim($mask, ',');

        if (count($filter) === static::OPERATOR_ARRAY_COUNT) {
            $key = $filter[0];
            $operand = $filter[1];
            $value = $filter[2];

            if (in_array($operand, static::AVAILABLE_OPERANDS)) {
                $sql = 'UPDATE ' . $tableName . ' SET ' . 'WHERE ' . $key . ' ' . $operand . ' ?';
                $this->query($sql, [$value]);
            }
        }
    }

    protected function catchErrors() {
        $errors = $this->stmt->errorInfo();

        if ($errors[0] !== PDO::ERR_NONE) {
            $this->setError($errors[2]);
            while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r($this->getErrors());echo("</pre>");die();
        }
    }

    private static function emptyTableException() {
        throw new Exception('table with this name is not defined');
    }

    private static function stringify($array) {
        $string = join($array, ', ');

        return rtrim($string, ',');
    }

}