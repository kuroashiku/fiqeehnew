<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogActiveUser extends Authenticatable
{
    protected $table = 'log_active_users';
    protected $fillable = [
        'date',
        'active_user',
        'inactive_user'
    ];
}
