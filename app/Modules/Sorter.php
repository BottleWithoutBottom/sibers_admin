<?php

namespace App\Modules;

class Sorter {
    public CONST ORDER = ['DESC' => 'Descending', 'ASC' => 'Ascending'];
    public CONST SORT = 'sort';

    public CONST TITLE = 'title';
    public CONST NAME = 'name';
    public CONST VALUES = 'values';
    public CONST AVAILABLE_SORTINGS = 'available_sortings';

    protected $uri;
    protected $sorterBuilder;
    protected $params = [];
    protected $availableFields = [];

    public function __construct($uri, $params = [], $availableFields = []) {
        $this->setUri($uri);
        $this->setParams($params);
        $this->setAvailableFields($availableFields);
    }

    public function generate() {
        $this->setSorterBuilder(new SortBuilder($this->getUri(), $this->getParams(), $this->getAvailableFields()));
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
     *  'values' => ['value1', 'value2', 'value3'],
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
}