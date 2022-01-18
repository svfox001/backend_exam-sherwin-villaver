<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user_id' => $this->title,
            'title' => $this->rating,
            'slug' => $this->rating,
            'content' => $this->rating,
            'created_at' => $this->rating,
            'updated_at' => $this->rating,
            'deleted_at' => null,
        ];
    }

    public static function meta()
    {
        return [
            'links' => self::collectionLinks(PostController::class),
        ];
    }
}
