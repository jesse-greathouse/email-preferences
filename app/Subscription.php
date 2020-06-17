<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
     /**
     * @var array
     */
    protected $fillable = ['newsletter_id', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function newsletter(): BelongsTo
    {
        return $this->belongsTo('App\NewsLetter');
    }
  }