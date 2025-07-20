<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextSettings extends Model
{
    protected $table = 'text_blast';
    protected $fillable = [
        'title',
        'text',
        'label', 
        'instance_id'
    ];

    public function instance()
    {
        return $this->hasOne(BlastingSettings::class, 'instance_id', 'instance_id');
    }
}