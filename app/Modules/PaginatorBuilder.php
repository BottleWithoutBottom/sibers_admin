<?php

namespace App\Modules;

class PaginatorBuilder {
    protected $allLinksCount;
    protected $currentPage;
    protected $paginatorClass = 'paginator';
    protected $linkClass = 'paginator-link';
    protected $currentLinkClass = 'active';

    protected $html;

    public function __construct($allLinksCount, $currentPage) {
        $this->setAllLinksCount($allLinksCount);
        $this->setCurrentPage($currentPage);
    }

    public function generate($uri) {
        $pageCounter = 0;
        $currentPage = $this->getCurrentPage();
        $this->html = '<div class="' . $this->paginatorClass . '">';

        while ($pageCounter < $this->getAllLinksCount()) {
            $isCurrent  = $pageCounter + 1 == $currentPage;
            $this->html .= $this->generateLink($uri, $pageCounter + 1, $isCurrent);
            $pageCounter++;
        }

        $this->html .= '</div>';

        return true;
    }

    public function generateLink($uri, $pageNumber, $isCurrent = false) {
        $href = Paginator::createHref($uri, $pageNumber);
        $isCurrentClass = $isCurrent ? ' ' . $this->currentLinkClass : '';
        return '<a href="' . $href . '"class="' . $this->linkClass . $isCurrentClass . '">' . $pageNumber . '</a>';
    }

    public function getHtml() {
        return $this->html;
    }

    /**
     * @return mixed
     */
    public function getAllLinksCount() {
        return $this->allLinksCount;
    }

    /**
     * @param mixed $allLinksCount
     */
    public function setAllLinksCount($allLinksCount): void {
        $this->allLinksCount = $allLinksCount;
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
}