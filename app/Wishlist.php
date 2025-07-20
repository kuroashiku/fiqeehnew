<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = [
        'course_id',
        'user_id'
    ];
    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
