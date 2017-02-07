<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    // public function show($id)
    public function show()
    {
        $student = $this->currentUser;
        return view('student.settings.profile')->with('user', $student);
    }

    public function showPassword()
    {
        $student = $this->currentUser;
        return view('student.settings.password')->with('user', $student);
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
    // public function update(Request $request, $id)
    public function update(Request $request)
    {
        $student = Student::find($this->currentUser->id);
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->description = $request->input('description');
        $student->save();
        return redirect()->to('/');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'new-password' => 'required|confirmed'
        ]);

        $student = Student::find($this->currentUser->id);
        $currentPassword = $request->input('password');
        $newPassword = $request->input('new-password');
        $confirmPassword = $request->input('new-password_confirmation');

        if (Hash::check($currentPassword, $student->password) && $newPassword == $confirmPassword) {
            $student->password = bcrypt($newPassword);
        }
        $student->save();
        return redirect()->to('/');
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
