<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieCardResource extends JsonResource
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
            'id' => $this['movie_id'],
            'title' => $this['title'],
            'cover' => $this['cover_img'],
            'rating' =>$this['rating'],
            'favorited_by_user' => isset($this['favorites']) ? \count($this['favorites']) > 0 : false,
            'detail' => $this->getDetailUrl()
        ];
    }

    private function getDetailUrl()
    {
        return \url('/api/movie/detail/'.$this['movie_id']);
    }
}
