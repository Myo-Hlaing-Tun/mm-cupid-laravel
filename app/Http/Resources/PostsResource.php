<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'thumb_path' => $this->thumb_path,
            'fullsize_photo_path' => $this->fullsize_photo_path,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
