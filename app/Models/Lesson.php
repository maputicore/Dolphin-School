<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = "lessons";

    protected $fillable = [
        'teacher_id', 'name', 'description'
    ];

    public function lessonsStudents()
    {
        return $this->belongsToMany('App\Models\LessonsStudent', 'lesson_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function isRegistered()
    {
        // dd($this->lessonsStudents());
        $registered = $this->lessonsStudent->where('student_id', Auth::guard('student')->user()->id)->first();
        dd($this->lessonsStudents()->all());
        return (!is_null($registered)) ? true : false;
    }
}
