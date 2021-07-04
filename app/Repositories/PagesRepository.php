<?php

namespace App\Repositories;

use App\Models\Pages;
use Illuminate\Pagination\LengthAwarePaginator;

interface PagesRepository
{
    public function createPage(string $name): Pages;

    public function getPages(string $sortBy, string $orderBy, int $currentPage, int $perPage): LengthAwarePaginator;

    public function getSinglePage(int $pageId): Pages;

    public function updatePage(int $pageId, string $name): Pages;
}
