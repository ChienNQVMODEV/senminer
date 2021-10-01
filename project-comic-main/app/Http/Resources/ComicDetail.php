<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComicDetail extends BaseResource
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
            'avatar' => $this->avatar,
            'name' => $this->name,
            'status' => $this->status,
            'category' => $this->category,
            'trailer' => $this->trailer,
            'comic_link' => $this->comic_link,
            'id_check' => $this->id_check,
            'created_at' => $this->created_at,
            'chapters' => ChapterHome::collection($this->chapters()->orderBy('chapters.order', 'desc')->get()),
        ];
    }
}
