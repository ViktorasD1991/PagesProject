<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleElementResource extends JsonResource
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
            'column_id' => $this->resource->column_id,
            'data' => $this->resource->data,
            'type' => $this->resource->type,
            'created_at' => $this->resource->created_at->format('Y.m.d H:i:s')
        ];
    }

}
