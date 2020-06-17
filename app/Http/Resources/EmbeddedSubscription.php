<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EmbeddedNewsLetter as NewsletterResource;

class EmbeddedSubscription extends JsonResource
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
            'newsletter'  => NewsletterResource::make($this->newsletter),
        ];
    }
}