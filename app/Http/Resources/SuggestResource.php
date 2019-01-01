<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Carbon;

class SuggestResource extends Resource
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
            'content' => $this->content,
            'response' => $this->response,
            'is_readed' => $this->is_readed,
            'created_at' => Carbon::now()->diffForHumans($this->created_at),
            'updated_at' => Carbon::now()->diffForHumans($this->updated_at),
        ];
    }
}
