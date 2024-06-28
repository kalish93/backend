<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\AssignedCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    //
    public function assignCourse(Request $request){
        $data = $request->validate([
            'teacher_id' => 'required',
            'course_id' => 'required',
            'section'=> 'required',
            'program' => 'required|string',
            'department' => 'required|string',
            'year' => 'required'
        ]);

        // $teacher = User::find($data['teacher_id']);
        // $teacher->assignedCourses()->attach($data['course_id']);

        $assigned = AssignedCourse::create([
            'teacher_id' => $data['teacher_id'],
            'course_id' => $data['course_id'],
            'section' => $data['section'],
            'program' => $data['program'],
            'department' => $data['department'],
            'year' => $data['year']
        ]);

        return response($assigned);
    }

    // public function getTeachers(){
    //     return User::where('role', 'Teacher')->get();
    // }

    public function getAssignedCourses(){
        $courses = DB::table('assigned_courses')->where('teacher_id', Auth::user()->id)->get();
        
        for ($i = 0; $i < count($courses); $i++) {
            $temp = Course::find($courses[$i]->course_id);
            $courses[$i]->course_name = $temp->course_name;
        }

        return response($courses);
    }

    public function getTeacherAssignedCourses($teacher_id){
        $courses = DB::table('assigned_courses')->where('teacher_id', $teacher_id)->get();
        return response($courses);
    }

}
