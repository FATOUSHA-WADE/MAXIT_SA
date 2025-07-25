<?php

namespace App\Core;

class Paginator
{
    public static function paginate(array $items, int $itemsPerPage = 10): array
    {
        $currentPage = (int)($_GET['page'] ?? 1);
        $totalItems = count($items);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = max(1, min($currentPage, $totalPages));
        
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedItems = array_slice($items, $offset, $itemsPerPage);
        
        return [
            'items' => $paginatedItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'itemsPerPage' => $itemsPerPage,
            'hasNext' => $currentPage < $totalPages,
            'hasPrevious' => $currentPage > 1
        ];
    }
}