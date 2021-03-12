<?php

namespace App;
use QuizTrait;
use App\Http\Traits\QuizTrait;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table ='quizzes';

    protected $fillable = [

        'name', 'clas_id', 'course_id'

        ];
}
