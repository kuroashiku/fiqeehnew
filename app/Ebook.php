<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $table = 'ebooks';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'file',
        'image',
        'free',
        'price',
        'author',
        'afiliasi_komisi',
        'physic'
    ];

    public function getPublishedTimeAttribute()
    {
        return $this->created_at->format(date_time_format());
    }
}
