<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EmbeddedNewsletter as NewsletterResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'newsletter'    => NewsletterResource::make($this->newsletter),
            'publish_date'  => $this->publish_date,
            'content'       => $this->content,
        ];
    }
}