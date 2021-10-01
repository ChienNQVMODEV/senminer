<?php

namespace App\Http\Resources;

use App\Http\Resources\ChapterHome;
use Illuminate\Http\Resources\Json\JsonResource;

class ComicHome extends BaseResource
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
            'chapters' => ChapterHome::collection($this->chapters()->take(3)->orderBy('chapters.order', 'desc')->get()),
        ];
    }
}
