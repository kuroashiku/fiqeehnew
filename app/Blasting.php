<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Blasting extends Model
{
    protected $table = 'blasting';
    protected $fillable = [
        'id_user',
        'acces_id',
        'message',
        'target_phone',
        'blast_created',
        'created_by'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
