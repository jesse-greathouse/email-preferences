<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\Relations\HasMany;

class Newsletter extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

        /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany('App\Post');
    }
}