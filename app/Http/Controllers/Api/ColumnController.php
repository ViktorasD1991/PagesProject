<?php

namespace App\Http\Controllers\Api;

use App\Constants\Elements;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddElementRequest;
use App\Http\Requests\Api\CreateColumnRequest;
use App\Http\Requests\Api\UpdateColumnRequest;
use App\Http\Resources\Api\ColumnResourceCollection;
use App\Http\Resources\Api\SingleColumnResource;
use App\Http\Resources\Api\SingleElementResource;
use App\Repositories\ColumnRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ColumnController
 */
class ColumnController extends Controller
{
    /**
     * Repositories needed for controller
     **/
    private $columnRepository;

    /**
     * ColumnController constructor
     *
     *
     * @param ColumnRepository $columnRepository
     */
    public function __construct(ColumnRepository $columnRepository)
    {
        $this->columnRepository = $columnRepository;
    }

    /**
     * Creates a new column for a row
     *
     * @param CreateColumnRequest $request
     * @return SingleColumnResource
     */
    public function create(CreateColumnRequest $request): SingleColumnResource
    {
        $row = $this->columnRepository->createColumn(
            $request->route()->parameter('rowId'),
            $request->input('name', '')
        );

        return new SingleColumnResource($row);
    }

    /**
     * Retrieves an overview of all columns  for a row
     *
     * @param Request $request
     * @return ColumnResourceCollection
     */
    public function get(Request $request): ColumnResourceCollection
    {
        $row = $this->columnRepository->getColumns(
            $request->route()->parameter('rowId')
        );

        return new ColumnResourceCollection($row);
    }

    /**
     * Retrieves an a single column
     *
     * @param Request $request
     * @return SingleColumnResource
     */
    public function getSingle(Request $request): SingleColumnResource
    {
        $row = $this->columnRepository->getSingleColumn(
            $request->route()->parameter('columnId'),
        );

        return new SingleColumnResource($row);
    }

    /**
     * Updates an a single column
     *
     * @param UpdateColumnRequest $request
     * @return SingleColumnResource
     */
    public function update(UpdateColumnRequest $request): SingleColumnResource
    {
        $row = $this->columnRepository->updateColumn(
            $request->route()->parameter('rowId'),
            $request->route()->parameter('columnId'),
            $request->input('name', ''),
            $request->input('order', null)
        );

        return new SingleColumnResource($row);
    }

    /**
     * Deletes a column
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->columnRepository->deleteColumn(
            $request->route()->parameter('columnId'),
        );

        return response()->json([], 204);
    }

    /**
     * Add a new element in a column
     *
     * @param AddElementRequest $request
     * @return SingleElementResource
     */
    public function addElement(AddElementRequest $request): SingleElementResource
    {
        $element = $this->columnRepository->addElementInColumn(
            $request->route()->parameter('columnId'),
            $request->input('type'),
            $request->input('data'),
        );

        return new SingleElementResource($element);
    }

    /**
     * Remove element from column
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeElement(Request $request): JsonResponse
    {
        $this->columnRepository->removeElementFromColumn(
            $request->route()->parameter('elementId'),
        );

        return response()->json([], 204);
    }
}
