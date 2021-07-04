<?php

namespace App\Repositories;

use App\Models\Columns;
use App\Models\Elements;
use Illuminate\Support\Collection;

interface ColumnRepository
{
    public function createColumn(int $rowId, string $name): Columns;

    public function getColumns(int $rowId): Collection;

    public function getSingleColumn(int $columnId): Columns;

    public function updateColumn(int $rowId, int $columnId, string $name,  $order): Columns;

    public function deleteColumn(int $columnId): Collection;

    public function addElementInColumn(int $columnId, string $type, string $data): Elements;

    public function removeElementFromColumn(int $elementId): Collection;
}
