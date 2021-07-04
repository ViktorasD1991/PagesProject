<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePageRequest;
use App\Http\Requests\Api\CreateRowRequest;
use App\Http\Requests\Api\UpdateRowRequest;
use App\Http\Resources\Api\PageResourceCollection;
use App\Http\Resources\Api\RowResourceCollection;
use App\Http\Resources\Api\SinglePageResource;
use App\Http\Resources\Api\SingleRowResource;
use App\Repositories\RowRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\PagesRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RowController
 */
class RowController extends Controller
{
    /**
     * Repositories needed for controller
     **/
    private $rowRepository;

    /**
     * RowController constructor
     *
     *
     * @param RowRepository $rowRepository
     */
    public function __construct(RowRepository $rowRepository)
    {
        $this->rowRepository = $rowRepository;
    }

    /**
     * Creates a new row for an existing page
     *
     * @param CreateRowRequest $request
     * @return SingleRowResource
     */
    public function create(CreateRowRequest $request): SingleRowResource
    {
        $row = $this->rowRepository->createRow(
            $request->route()->parameter('pageId'),
            $request->input('name', '')
        );

        return new SingleRowResource($row);
    }

    /**
     * Retrieves an overview of all rows for a page
     *
     * @param Request $request
     * @return RowResourceCollection
     */
    public function get(Request $request): RowResourceCollection
    {
        $row = $this->rowRepository->getRows(
            $request->route()->parameter('pageId')
        );

        return new RowResourceCollection($row);
    }

    /**
     * Retrieves an a single row
     *
     * @param Request $request
     * @return SingleRowResource
     */
    public function getSingle(Request $request): SingleRowResource
    {
        $row = $this->rowRepository->getSingleRow(
            $request->route()->parameter('pageId'),
            $request->route()->parameter('rowId'),
        );

        return new SingleRowResource($row);
    }

    /**
     * Updates an a single row
     *
     * @param UpdateRowRequest $request
     * @return SingleRowResource
     */
    public function update(UpdateRowRequest $request): SingleRowResource
    {
        $row = $this->rowRepository->updateRow(
            $request->route()->parameter('pageId'),
            $request->route()->parameter('rowId'),
            $request->input('name', ''),
            $request->input('order', null)
        );

        return new SingleRowResource($row);
    }

    /**
     * Deletes an entire row
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->rowRepository->deleteRow(
            $request->route()->parameter('pageId'),
            $request->route()->parameter('rowId'),
        );

        return response()->json([], 204);
    }
}
