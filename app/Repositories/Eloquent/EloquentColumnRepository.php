<?php

namespace App\Repositories\Eloquent;

use App\Models\Columns;
use App\Models\Elements;
use App\Repositories\ColumnRepository;
use Illuminate\Support\Collection;

class EloquentColumnRepository implements ColumnRepository
{
    /**
     * @var Columns $columnModel
     */
    private $columnModel;

    /**
     * @var Elements $elementModel
     */
    private $elementModel;

    /**
     * EloquentColumnRepository constructor
     *
     * @param Columns $columnModel
     * @param Elements $elementModel
     */
    public function __construct(Columns $columnModel, Elements $elementModel)
    {
        $this->columnModel = $columnModel;
        $this->elementModel = $elementModel;
    }

    /**
     * Creates a new column for a row
     *
     * @param int $rowId
     * @param string $name
     *
     * @return Columns
     */
    public function createColumn(int $rowId, string $name): Columns
    {
        $order = $this->columnModel->where('row_id', '=', $rowId)->count();

        $column = $this->columnModel->create([
            'row_id' => $rowId,
            'name' => $name,
            'order' => $order + 1,
        ]);

        return $column;
    }

    /**
     * Retrieves all columns for a row
     *
     * @param int $rowId
     *
     * @return Collection
     */
    public function getColumns(int $rowId): Collection
    {
        $columns = $this->columnModel->where('row_id', '=', $rowId)->get();

        return $columns;
    }

    /**
     * Retrieves a single column with it's contents
     *
     * @param int $columnId
     *
     * @return Columns
     */
    public function getSingleColumn(int $columnId): Columns
    {
        $column = $this->columnModel
            ->where('id', '=', $columnId)
            ->first();

        return $column;
    }

    /**
     * Updates a column
     *
     * @param int $rowId
     * @param int $columnId
     * @param string $name
     * @param  $order
     *
     * @return Columns
     */
    public function updateColumn(int $rowId, int $columnId, string $name, $order): Columns
    {
        $column = $this->columnModel
            ->where('id', '=', $columnId)
            ->first();

        if (!empty($name)) {
            $column->name = $name;
        }

        if (!empty($order)) {
            $reorderedColumn = $this->columnModel
                ->where('row_id', '=', $rowId)
                ->where('order', '=', $order)
                ->first();

            if (!empty($reorderedColumn)) {
                $reorderedColumn->order = $column->order;
                $reorderedColumn->save();
            }
            $column->order = $order;
        }

        $column->save();

        return $column;
    }

    /**
     * Deletes a column
     *
     * @param int $columnId
     *
     * @return Collection
     */
    public function deleteColumn(int $columnId): Collection
    {
        $this->columnModel
            ->where('id', '=', $columnId)
            ->delete();

        return collect([]);
    }

    /**
     * Adds a new element in a column
     *
     * @param int $columnId
     * @param string $type
     * @param string $data
     *
     * @return Elements
     */
    public function addElementInColumn(int $columnId, string $type, string $data): Elements
    {
        $element = $this->elementModel->create([
            'column_id' => $columnId,
            'type' => $type,
            'data' => $data,
        ]);

        return $element;
    }

    /**
     * Removes an element from a column
     *
     * @param int $elementId
     *
     * @return Collection
     */
    public function removeElementFromColumn(int $elementId): Collection
    {
        $this->elementModel->where('id', '=', $elementId)->delete();

        return collect([]);
    }
}
