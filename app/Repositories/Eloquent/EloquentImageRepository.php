<?php

namespace App\Repositories\Eloquent;

use App\Models\Columns;
use App\Models\Images;
use App\Repositories\ColumnRepository;
use App\Repositories\ImageRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentImageRepository implements ImageRepository
{
    /**
     * @var Images $imageModel
     */
    private $imageModel;

    /**
     * EloquentImageRepository constructor
     *
     * @param Images $imageModel
     */
    public function __construct(Images $imageModel)
    {
        $this->imageModel = $imageModel;
    }

    /**
     * Retrieves all images
     *
     * @param string $sortBy
     * @param string $orderBy
     * @param int $currentPage
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getImages(string $sortBy, string $orderBy, int $currentPage, int $perPage): LengthAwarePaginator
    {
        $images = $this->imageModel->orderBy($sortBy, $orderBy)->paginate($perPage, ['*'], 'page', $currentPage);

        return $images;
    }

    /**
     * Uploades a new image
     *
     * @param string $fileName
     * @param string $path
     *
     * @return Images
     */
    public function uploadImage(string $fileName, string $path): Images
    {
        $image = $this->imageModel->create([
            'name' => $fileName,
            'path' => $path,
        ]);

        return $image;
    }

    /**
     * Removes an image from the image library
     *
     * @param int $imageId
     *
     * @return Collection
     */
    public function deleteImage(int $imageId): Collection
    {
        $this->imageModel->where('id', '=', $imageId)->delete();

        return collect([]);
    }

    /**
     * Returns a single image data
     *
     * @param int $imageId
     *
     * @return Images
     */
    public function getSingleImage(int $imageId): Images
    {
        $image = $this->imageModel->where('id', '=', $imageId)->first();

        return $image;
    }
}
