<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
