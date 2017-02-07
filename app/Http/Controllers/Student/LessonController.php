<?php

namespace App\Http\Controllers\Student;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonsStudent;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::all();
        $lessonsStudents = LessonsStudent::all();

        return view('student.dashboard')->with('lessons', $lessons);
    }

    public function register($id)
    {
        $lessonId = $id;
        $studentId = $this->currentUser->id;

        $lessonsStudent = LessonsStudent::updateOrCreate([
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
        ], [
            'is_join' => 1,
        ]);

        return redirect()->to('/lesson/'.$lessonId);
    }

    public function cancel($id)
    {
        $lessonId = $id;
        $studentId = $this->currentUser->id;

        $lessonsStudent = LessonsStudent::where('lesson_id', $lessonId)->where('student_id', $studentId)->first();
        $lessonsStudent->is_join = 0;
        $lessonsStudent->save();

        return redirect()->to('/lesson/'.$lessonId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        $studentId = $this->currentUser->id;

        $sessionId = bcrypt($lesson->id . '_' . $lesson->name . '_' . $lesson->teacher->id . '_' . $lesson->teacher->name);
        $sessionId = preg_replace('/[^ぁ-んァ-ンーa-zA-Z0-9一-龠0-9\-\r]+/u', '', $sessionId);
        $sessionId = substr($sessionId, 0, 32);

        $lessonsStudent = LessonsStudent::where('lesson_id', $id)->where('student_id', $studentId)->first();

        $isRegistered = ($lessonsStudent->is_join == 1);

        return view('student.lesson.detail')->with(['lesson' => $lesson, 'isRegistered' => $isRegistered, 'sessionId' => $sessionId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
