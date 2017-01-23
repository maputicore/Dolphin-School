<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonsStudent extends Model
{
    protected $fillable = [
        'teacher_id', 'student_id', 'is_join'
    ];
}
