<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email'];

        /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany('App\Subscription');
    }
}
