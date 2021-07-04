<?php

namespace App\Repositories\Eloquent;

use App\Models\Pages;
use App\Repositories\PagesRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentPagesRepository implements PagesRepository
{
    /**
     * @var Pages $pagesModel
     */
    private $pagesModel;

    /**
     * EloquentPagesRepository constructor
     *
     * @param Pages $pagesModel
     */
    public function __construct(Pages $pagesModel)
    {
        $this->pagesModel = $pagesModel;
    }

    /**
     * Creates a new page for the application
     *
     * @param string $name
     *
     * @return Pages
     */
    public function createPage(string $name): Pages
    {
        $page = $this->pagesModel->create([
            'name' => $name
        ]);

        return $page;
    }

    /**
     * Retrieves all pages
     *
     * @param string $sortBy
     * @param string $orderBy
     * @param int $currentPage
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getPages(string $sortBy, string $orderBy, int $currentPage, int $perPage): LengthAwarePaginator
    {
        $pages = $this->pagesModel->orderBy($sortBy, $orderBy)->paginate($perPage, ['*'], 'page', $currentPage);

        return $pages;
    }

    /**
     * Creates a new page for the application
     *
     * @param int $pageId
     *
     * @return Pages
     */
    public function getSinglePage(int $pageId): Pages
    {
        $page = $this->pagesModel->where('id', '=', $pageId)->first();

        return $page;
    }

    /**
     * Updates a page data
     *
     * @param int $pageId
     * @param string $name
     *
     * @return Pages
     */
    public function updatePage(int $pageId, string $name): Pages
    {
        $page = $this->pagesModel->where('id', '=', $pageId)->first();

        if (!empty($name)) {
            $page->name = $name;
        }

        $page->save();

        return $page->fresh();
    }
}
