<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AfiliasiPayment extends Model
{
    protected $table = 'afiliasi_payments';
    protected $fillable = [
        'user_afiliasi_id',
        'amount',
        'status',
        'detail_payment',
        'is_delete'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
