<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryCourse extends Model
{
    protected $table = 'category_courses';
    protected $fillable = [
        'course_id',
        'category_id'
    ];
    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
