<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPayment extends Model
{
    protected $table = 'user_payments';
    protected $fillable = [
        'user_id',
        'amount',
        'unique_amount',
        'status',
        'detail_payment',
        'verified_at',
        'monthly',
        'product',
        'started_at',
        'expired_at', 
        'category_product',
        'product_ads',
        'last_payment',
        'tanggal_jatuh_tempo'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
