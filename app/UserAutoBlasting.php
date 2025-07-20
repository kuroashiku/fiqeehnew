<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAutoBlasting extends Model
{
    protected $table = 'user_auto_blastings';
    protected $fillable = [
        'title',
        'filter',
        'repeat_days',
        'message',
        'last_execution_date',
        'next_call_date'
    ];
}
