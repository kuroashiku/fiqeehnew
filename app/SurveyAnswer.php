<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyAnswer extends Model
{
    protected $table = 'survey_answers';
    protected $fillable = [
        'user_id',
        'survey_question_id',
        'answer'
    ];

    // public function course()
    // {
    //     return $this->hasOne(Course::class, 'id', 'course_id');
    // }
}
