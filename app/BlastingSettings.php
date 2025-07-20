<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlastingSettings extends Model
{
    protected $table = 'blasting_settings';
    protected $fillable = [
        'nomor',
        'instance_id'
    ];
}
