<?php

namespace App\Modules;
use App\Modules\PaginatorBuilder;

class Paginator {
    public CONST QUERY = 'PAGE';

    protected $itemsToShow;
    protected $allItemsCount;
    protected $currentPage;
    protected $firstRow;
    protected $lastRow;
    protected $uri;
    protected $paginatorBuilder;

    public function __construct($allItemsCount, $itemsToShow, $curentPage, $uri) {
        $this->setAllItemsCount($allItemsCount);
        $this->setItemsToShow($itemsToShow);
        $this->setCurrentPage($curentPage);
        $this->setUri($uri);
        $this->setFirstRow();
        $this->setLastRow();
    }

    public function generate() {
        $linksCount = $this->getAllItemsCount() / $this->getItemsToShow();
        $this->paginatorBuilder = new PaginatorBuilder($linksCount, $this->getCurrentPage());
        $this->paginatorBuilder->generate($this->getUri());
    }

    public function getHtml() {
        return $this->paginatorBuilder->getHtml();
    }

    /**
     * @return mixed
     */
    public function getItemsToShow() {
        return $this->itemsToShow;
    }

    /**
     * @param mixed $itemsToShow
     */
    public function setItemsToShow($itemsToShow): void {
        $this->itemsToShow = $itemsToShow;
    }

    /**
     * @return mixed
     */
    public function getAllItemsCount() {
        return $this->allItemsCount;
    }

    /**
     * @param mixed $allItemsCount
     */
    public function setAllItemsCount($allItemsCount): void {
        $this->allItemsCount = $allItemsCount;
    }

    /**
     * @return mixed
     */
    public function getCurrentPage() {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($currentPage): void {
        $this->currentPage = $currentPage;
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
     * @return mixed
     */
    public function getFirstRow() {
        return $this->firstRow;
    }

    /**
     * @param mixed $firstRow
     */
    public function setFirstRow() {
        if ($this->getCurrentPage() == 1) {
            $this->firstRow = 0;
        } else {
            $this->firstRow = $this->getCurrentPage() * $this->getItemsToShow() - $this->getItemsToShow();

        }
    }

    /**
     * @return mixed
     */
    public function getLastRow() {
        return $this->lastRow;
    }

    /**
     * @param mixed $lastRow
     */
    public function setLastRow() {
        $this->lastRow = $this->getItemsToShow();
        return true;
    }

    public static function createHref($uri, $page) {
        //вырезаем предыдущий get-запрос, если таковой имеется
        $uri = preg_replace('#^?' . static::QUERY . '=' . '[0-9]*' . '$#', '', $uri);
        return $uri . '?' . static::QUERY . '=' . $page;
    }

}