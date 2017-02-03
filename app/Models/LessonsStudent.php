<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonsStudent extends Model
{
    protected $table = "lessons_students";

    protected $fillable = [
        'lesson_id', 'student_id', 'is_join'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson');
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }
}
