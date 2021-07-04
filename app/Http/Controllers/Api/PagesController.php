<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePageRequest;
use App\Http\Requests\Api\UpdatePageRequest;
use App\Http\Resources\Api\PageResourceCollection;
use App\Http\Resources\Api\SinglePageResource;
use Illuminate\Http\Request;
use App\Repositories\PagesRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PagesController
 */
class PagesController extends Controller
{
    /**
     * Repositories needed for controller
     **/
    private $pagesRepository;

    /**
     * PagesController constructor
     *
     *
     * @param PagesRepository $pagesRepository
     */
    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * Creates a blank new page
     *
     * @param CreatePageRequest $request
     * @return SinglePageResource
     */
    public function create(CreatePageRequest $request): SinglePageResource
    {
        $page = $this->pagesRepository->createPage(
            $request->input('name')
        );

        return new SinglePageResource($page);
    }

    /**
     * Retrieves an overview of all pages
     *
     * @param Request $request
     * @return PageResourceCollection
     */
    public function get(Request $request): PageResourceCollection
    {
        $pages = $this->pagesRepository->getPages(
            $request->input('sort_by','id'),
            $request->input('order_by','asc'),
            $request->input('page',1),
            $request->input('per_page',20),
        );

        return new PageResourceCollection($pages);
    }

    /**
     * Retrieves a single page
     *
     * @param Request $request
     * @return SinglePageResource
     */
    public function getSingle(Request $request): SinglePageResource
    {
        $page = $this->pagesRepository->getSinglePage(
            $request->route()->parameter('pageId')
        );

        return new SinglePageResource($page);
    }

    /**
     * Updates the page data
     *
     * @param UpdatePageRequest $request
     * @return SinglePageResource
     */
    public function update(UpdatePageRequest $request): SinglePageResource
    {
        $page = $this->pagesRepository->updatePage(
            $request->route()->parameter('pageId'),
            $request->input('name','')
        );

        return new SinglePageResource($page);
    }
}
