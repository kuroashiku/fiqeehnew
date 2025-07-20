<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';
    protected $fillable = [
        'question',
        'publish',
        'type',
        'answer'
    ];

    // public function course()
    // {
    //     return $this->hasOne(Course::class, 'id', 'course_id');
    // }
}
