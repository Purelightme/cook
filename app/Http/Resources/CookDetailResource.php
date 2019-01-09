<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CookDetailResource extends Resource
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
            'category_titles' => $this->category_titles,
            'title' => $this->title,
            'img' => $this->img,
            'ingredients' => $this->ingredients,
            'method' => $this->method,
        ];
    }
}