<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EmbeddedNewsLetter as NewsletterResource;
use App\Http\Resources\EmbeddedUser as UserResource;

class Subscription extends JsonResource
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
            'user'        => UserResource::make($this->user),
            'newsletter'  => NewsletterResource::make($this->newsletter),
        ];
    }
}