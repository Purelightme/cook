<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StoryDetailResource extends Resource
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
            'title' => $this->title,
            'content' => $this->content,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
