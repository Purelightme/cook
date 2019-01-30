<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BannerResource extends Resource
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
            'img' => getImageUrl($this->img),
            'path' => $this->path
        ];
    }
}
