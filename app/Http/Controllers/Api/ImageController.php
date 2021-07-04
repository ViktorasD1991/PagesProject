<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageUploadRequest;
use App\Http\Resources\Api\ImageResource;
use App\Http\Resources\Api\ImageResourceCollection;
use App\Repositories\ImageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


/**
 * Class ImageController
 */
class ImageController extends Controller
{
    /**
     * Repositories needed for controller
     **/
    private $imageRepository;

    /**
     * ColumnController constructor
     *
     *
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * Retrieves all images
     *
     * @param Request $request
     * @return ImageResourceCollection
     */
    public function get(Request $request): ImageResourceCollection
    {
        $images = $this->imageRepository->getImages(
            $request->input('sort_by', 'id'),
            $request->input('order_by', 'asc'),
            $request->input('page', 1),
            $request->input('per_page', 20)
        );

        return new ImageResourceCollection($images);
    }

    /**
     * Retrieves all images
     *
     * @param ImageUploadRequest $request
     * @return ImageResource
     */
    public function upload(ImageUploadRequest $request): ImageResource
    {
        $fileName = uniqid('images_') . $request->file('file')->getClientOriginalName();
        $path = 'public/images/' . $fileName;

        \Storage::disk('local')->put($path, file_get_contents($request->file('file')), 'public');

        $images = $this->imageRepository->uploadImage(
            $fileName,
            $path
        );

        return new ImageResource($images);
    }

    /**
     * Delete Image
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $image = $this->imageRepository->getSingleImage(
            $request->route()->parameter('imageId')
        );

        $this->imageRepository->deleteImage(
            $request->route()->parameter('imageId')
        );

        \Storage::disk('local')->delete($image->path);

        return response()->json([],204);
    }
}
