<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\RegisteredCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseForRegistration;

class CourseForRegistrationController extends Controller
{
    //

    public function getCoursesForRegistration($year, $semester){
        $student = Student::where('user_id', Auth::user()->id)->first();
        $courses = CourseForRegistration::where('year', $year)->where('semester', $semester)->where('department',$student->department)->where('program', $student->program)->get();
        $coursesToRegister = [];

        $registered = RegisteredCourse::where('user_id', Auth::user()->id)->where('year', $year)->where('semester', $semester)->get();
        if(count($registered) > 0){
            foreach($registered as $course){
                array_push($coursesToRegister, Course::find($course->course_id));
            }
            return response(['registered'=> true,
                            'courses'=> $coursesToRegister
        ]);
        }elseif(count($courses) > 0){
            foreach($courses as $course){
                array_push($coursesToRegister, Course::find($course->course_id));
            }
            return response(['registered'=> false,
                            'courses'=> $coursesToRegister]);
        }else{
            return response(['message'=> 'you dont have any course for this semester']);
        }


    }

    public function create(Request $request){
        $data = $request->validate([
            'year' => 'required|integer',
            'semester' => 'required|integer',
            'course_ids' => 'required|array' ,
            'end_date'=> 'required',
            'program' => 'required',
            'department' => 'required'
        ]);

        foreach($data['course_ids'] as $id){
            CourseForRegistration::create([
                'year' => $data['year'],
                'semester' => $data['semester'],
                'course_id' => $id,
                'end_date' => $data['end_date'],
                'department' => $data['department'],
                'program' => $data['program']
            ]);
        }

        return response(["message" => "registration created succefully"]);
    }


    public function endRegistration(){

        $courses_to_register = CourseForRegistration::all();

    }
}
