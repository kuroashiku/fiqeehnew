<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentAds extends Model 
{
    protected $table = 'payments_ads';
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
        'expired_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
