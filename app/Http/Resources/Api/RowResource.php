<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'page_id' => $this->resource->page_id,
            'name' => $this->resource->name,
            'order' => $this->resource->order,
            'columns' => new ColumnResourceCollection($this->resource->columns),
            'created_at' => $this->resource->created_at->format('Y.m.d H:i:s')
        ];
    }

}
