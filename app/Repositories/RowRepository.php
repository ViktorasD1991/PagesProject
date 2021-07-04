<?php

namespace App\Repositories;

use App\Models\Rows;
use Illuminate\Support\Collection;

interface RowRepository
{
    public function createRow(int $pageId, string $name): Rows;

    public function getRows(int $pageId): Collection;

    public function getSingleRow(int $pageId, int $rowId): Rows;

    public function updateRow(int $pageId, int $rowId, string $name,  $order): Rows;

    public function deleteRow(int $pageId, int $rowId): Collection;
}
