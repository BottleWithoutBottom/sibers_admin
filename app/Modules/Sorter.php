<?php

namespace App\Modules;
use App\Core\Request;

class Sorter {
    public CONST ORDER = ['Descending' => 'DESC', 'Ascending' => 'ASC'];
    public CONST SORT = 'sort';

    public CONST TITLE = 'title';
    public CONST NAME = 'name';
    public CONST VALUES = 'values';
    public const SORT_FIELDS = 'sort_fields';
    public const SORT_FIELD_1 = 'sort_field_1';
    public const SORT_FIELD_1_VALUE = 'Sorting by: ';

    protected $uri;
    protected $sorterBuilder;
    protected $params = [];
    protected $availableFields = [];

    public function __construct($uri, $params = []) {
        $this->setUri($uri);
        $this->setParams($params);
        $this->setAvailableFields($params[static::VALUES]);
    }

    public function generate() {
        $this->setSorterBuilder(new SortBuilder($this->getUri(), $this->getParams()));
        $this->getSorterBuilder()->generate();
    }

    public function getHtml() {
        return $this->getSorterBuilder()->getHtml();
    }

    /**
     * @return mixed
     */
    public function getSorterBuilder() {
        return $this->sorterBuilder;
    }

    /**
     * @param mixed $sorterBuilder
     */
    public function setSorterBuilder($sorterBuilder): void {
        $this->sorterBuilder = $sorterBuilder;
    }

    /**
     * @return mixed
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param string $sortField
     * @param mixed $param
     * [
     *  'title' => 'fieldTitle',
     *  'name' => 'fieldName'
     *  'values' => ['sort1', 'sort2', 'sort3'],
     * ]
     */
    public function setParam($sortField, $param) {
        if (empty($sortField) || empty($param)) return false;

        $this->params[$sortField] = $param;
    }

    public function setParams($params) {
        if (empty($params)) return false;

        foreach ($params as $sortField => $param) {
            $this->setParam($sortField, $param);
        }
    }

    /**
     * @return mixed
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri): void {
        $this->uri = $uri;
    }

    /**
     * @return array
     */
    public function getAvailableFields(): array {
        return $this->availableFields;
    }

    /**
     * @param array $availableFields
     */
    public function setAvailableFields(array $availableFields): void {
        $this->availableFields = $availableFields;
    }

    /** method is loohing for sorting fields from GET-param */
    public static function getSortFromQuery($availableFields = []) {
        $request = Request::getInstance();
        $queryList = $request->getQueryList();
        $sort = $queryList[static::SORT];
        if (!empty($sort) && in_array($sort, static::ORDER)) {
            $res[static::SORT] = $sort;

            foreach($queryList as $queryName => $query) {
                if ($queryName == static::SORT_FIELD_1) {
                    $res[static::SORT_FIELDS][$queryName] = $query;
                }
            }
            return $res;
        }

        return false;
    }

}