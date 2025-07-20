<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbookDownload extends Model
{
    protected $table = 'ebook_downloads';
    protected $fillable = [
        'ebook_id',
        'user_afiliasi_id',
        'nama',
        'email',
        'no_hp',
        'pekerjaan',
        'kota',
        'alamat',
        'payment_nominal',
        'payment_detail',
        'payment_status',
        'no_resi',
        'afiliasi_komisi'
    ];

    public function getPublishedTimeAttribute()
    {
        return $this->created_at->format(date_time_format());
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }
    
    public function afiliasi()
    {
        return $this->belongsTo(User::class, 'user_afiliasi_id');
    }
}
