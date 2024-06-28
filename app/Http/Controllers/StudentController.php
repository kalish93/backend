<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\RegisteredCourse;

class StudentController extends Controller
{
    //

    public function studentsRegisteredForACourse( $course_id, $section){
        $courses = RegisteredCourse::where('course_id', $course_id)->get();

        $students = [];
        foreach($courses as $course){
            $user = User::find($course->user_id);
            $student = Student::where('user_id', $user->id)->where('section', $section)->first();
            if($student){
                array_push($students,[
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'student_id' => $student->student_id,
                    'section' => $student->section
                ]);
            }
        }

        return response($students);
    }
}
