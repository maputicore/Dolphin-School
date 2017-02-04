<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::all();
        return view('teacher.dashboard')->with('lessons', $lessons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lesson = new Lesson();
        $lesson->teacher_id = $this->currentUser->id;
        $lesson->name = $request->input('name');
        $lesson->description = $request->input('description');
        $lesson->joining_qualification = $request->input('joining_qualification');
        $lesson->start_time = $request->input('start_time');
        $lesson->finish_time = $request->input('finish_time');
        $lesson->save();
        return redirect()->to('/');
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
        $sessionId = bcrypt($lesson->id . '_' . $lesson->name . '_' . $lesson->teacher->id . '_' . $lesson->teacher->name);
        $sessionId = preg_replace('/[^ぁ-んァ-ンーa-zA-Z0-9一-龠0-9\-\r]+/u', '', $sessionId);
        $sessionId = substr($sessionId, 0, 32);
        // $lessonsStudent = LessonsStudent::where('lesson_id', $id)->first();

        // $isRegistered = ($lessonsStudent->student_id == $this->currentUser->id);

        return view('teacher.lesson.detail')->with(['lesson' => $lesson, 'sessionId' => $sessionId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::find($id);

        return view('teacher.lesson.edit')->with('lesson', $lesson);
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
        $lesson = Lesson::find($id);
        $lesson->name = $request->input('name');
        $lesson->description = $request->input('description');
        $lesson->joining_qualification = ($j_q = $request->input('joining_qualification') != '') ? $j_q: null;
        $lesson->start_time = $request->input('start_time');
        $lesson->finish_time = $request->input('finish_time');
        $lesson->save();
        return redirect()->to('/lesson/'.$id);
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
