<?php
class Pagination {
    private $currentPage;
    private $recordsPerPage;
    private $totalRecords;

    public function __construct($currentPage = 1, $recordsPerPage = 20, $totalRecords = 0) {
        $this->currentPage = (int)$currentPage;
        $this->recordsPerPage = (int)$recordsPerPage;
        $this->totalRecords = (int)$totalRecords;
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->recordsPerPage;
    }

    public function getLimit() {
        return $this->recordsPerPage;
    }

    public function getTotalPages() {
        return ceil($this->totalRecords / $this->recordsPerPage);
    }

    public function hasPreviousPage() {
        return $this->currentPage > 1;
    }

    public function hasNextPage() {
        return $this->currentPage < $this->getTotalPages();
    }

    public function previousPage() {
        return $this->currentPage - 1;
    }

    public function nextPage() {
        return $this->currentPage + 1;
    }

    public function generateHtml($baseUrl) {
        $html = '<div class="pagination-container" style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">';
        
        if ($this->hasPreviousPage()) {
            $html .= '<a href="' . $baseUrl . '?page=' . $this->previousPage() . '" class="btn btn-outline-primary">&laquo; Previous</a>';
        }
        
        // Simple page numbers (could be enhanced for many pages)
        for ($i = 1; $i <= $this->getTotalPages(); $i++) {
            $activeClass = ($i == $this->currentPage) ? 'btn-primary' : 'btn-outline-primary';
            $html .= '<a href="' . $baseUrl . '?page=' . $i . '" class="btn ' . $activeClass . '">' . $i . '</a>';
        }

        if ($this->hasNextPage()) {
            $html .= '<a href="' . $baseUrl . '?page=' . $this->nextPage() . '" class="btn btn-outline-primary">Next &raquo;</a>';
        }
        
        $html .= '</div>';
        return $html;
    }
}
