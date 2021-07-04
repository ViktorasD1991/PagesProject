<?php

namespace App\Repositories;

use App\Models\Images;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ImageRepository
{
    public function getImages(string $sortBy, string $orderBy, int $currentPage, int $perPage): LengthAwarePaginator;

    public function uploadImage(string $fileName, string $path): Images;

    public function deleteImage(int $imageId): Collection;

    public function getSingleImage(int $imageId): Images;
}
