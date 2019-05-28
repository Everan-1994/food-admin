<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'image' => $this->image,
            'intro' => $this->intro,
            'from' => $this->from,
            'created_at' => date('Y/m/d', $this->created_at->timestamp)
        ];
    }
}
