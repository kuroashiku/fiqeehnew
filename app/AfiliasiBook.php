<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AfiliasiBook extends Model
{
    protected $table = 'afiliasi_books';
    protected $fillable = [
        'ebook_id',
        'user_afiliasi_id',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'payment_photo',
        'afiliasi_komisi',
        'status',
        'no_resi',
    ];

    public function getPublishedTimeAttribute()
    {
        return $this->created_at->format(date_time_format());
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
}
