<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $appends = ['percentage', 'percentage_report'];

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id')->where('status', 1);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id', 'name', 'email');
    }

    public function course_user()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    
    public function getPercentageAttribute($value)
    {
        $user = \App\User::find($this->user_id);

        if ($user) {
            $completed_course = (array) $user->get_option('completed_courses');
            return (int) array_get($completed_course, $this->course_id . ".percent");
        }
    }

    public function getPercentageReportAttribute($value)
    {
        $total_contents = (int) Content::whereCourseId($this->course_id)->count();
        $completes = Complete::whereUserId($this->user_id)->whereNotNull('completed_at')->whereCourseId($this->course_id)->pluck('content_id');
        $completed_count = $completes->count();
        $percent = 0;
        if ($total_contents && $completed_count) {
            $percent = (int)number_format(($completed_count * 100) / $total_contents);
        }
        return $percent;
    }
}
