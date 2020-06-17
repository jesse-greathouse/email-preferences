<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['newsletter_id', 'publish_date', 'content'];

    /**
     * @var \DateTime
     */
    protected $publish_date;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return BelongsTo
     */
    public function newsletter(): BelongsTo
    {
        return $this->belongsTo('App\NewsLetter');
    }
}