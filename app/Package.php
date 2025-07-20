<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'discount_price',
        'status'
    ];

    public function getPublishedTimeAttribute()
    {
        return $this->created_at->format(date_time_format());
    }
}
