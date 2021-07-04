<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ColumnResource extends JsonResource
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
            'row_id' => $this->resource->row_id,
            'name' => $this->resource->name,
            'order' => $this->resource->order,
            'elements' => new ElementResourceCollection($this->resource->elements),
            'created_at' => $this->resource->created_at->format('Y.m.d H:i:s')
        ];
    }

}
