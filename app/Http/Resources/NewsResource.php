<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'type'          => $this->type,
            'title'         => $this->title,
            'image'         => $this->image,
            'video'         => $this->video,
            'intro'         => $this->intro,
            'resource_type' => $this->resource_type,
            'content'       => $this->content,
            'detail_image'  => $this->detail_image,
            'from'          => $this->from,
            'created_at'    => $this->created_at->toDateString(),
        ];
    }
}
