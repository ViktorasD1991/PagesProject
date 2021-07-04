<?php

namespace App\Repositories\Eloquent;

use App\Models\Pages;
use App\Models\Rows;
use App\Repositories\RowRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentRowRepository implements RowRepository
{
    /**
     * @var Rows $rowModel
     */
    private $rowModel;

    /**
     * EloquentRowRepository constructor
     *
     * @param Rows $rowModel
     */
    public function __construct(Rows $rowModel)
    {
        $this->rowModel = $rowModel;
    }

    /**
     * Creates a new row for a page
     *
     * @param int $pageId
     * @param string $name
     *
     * @return Rows
     */
    public function createRow(int $pageId, string $name): Rows
    {
        $order = $this->rowModel->where('page_id', '=', $pageId)->count();

        $row = $this->rowModel->create([
            'page_id' => $pageId,
            'name' => $name,
            'order' => $order + 1,
        ]);

        return $row;
    }

    /**
     * Retrieves all rows for a page
     *
     * @param int $pageId
     *
     * @return Collection
     */
    public function getRows(int $pageId): Collection
    {
        $rows = $this->rowModel->with('columns')->where('page_id', '=', $pageId)->get();

        return $rows;
    }

    /**
     * Retrieves a single row
     *
     * @param int $pageId
     * @param int $rowId
     *
     * @return Rows
     */
    public function getSingleRow(int $pageId, int $rowId): Rows
    {
        $row = $this->rowModel
            ->where('page_id', '=', $pageId)
            ->where('id', '=', $rowId)
            ->first();

        return $row;
    }

    /**
     * Updates a row
     *
     * @param int $pageId
     * @param int $rowId
     * @param string $name
     * @param  $order
     *
     * @return Rows
     */
    public function updateRow(int $pageId, int $rowId, string $name, $order): Rows
    {
        $row = $this->rowModel
            ->where('page_id', '=', $pageId)
            ->where('id', '=', $rowId)
            ->first();

        if (!empty($name)) {
            $row->name = $name;
        }

        if (!empty($order)) {
            $reorderedRow = $this->rowModel
                ->where('page_id', '=', $pageId)
                ->where('order', '=', $order)
                ->first();

            if (!empty($reorderedRow)) {
                $reorderedRow->order = $row->order;
                $reorderedRow->save();
            }
            $row->order = $order;
        }

        $row->save();

        return $row;
    }


    /**
     * Deletes a row
     *
     * @param int $pageId
     * @param int $rowId
     *
     * @return Collection
     */
    public function deleteRow(int $pageId, int $rowId): Collection
    {
        $this->rowModel
            ->where('page_id', '=', $pageId)
            ->where('id', '=', $rowId)
            ->delete();

        return collect([]);
    }
}
