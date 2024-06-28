<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseResult;
use Illuminate\Http\Request;
use App\Models\RegisteredCourse;
use App\Models\sgpa;

class sgpaController extends Controller
{
    //

    public function calculateCGPA(Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'sgp',
            'sgpa',
        ]);

        $sgp = 0;
        $totalects = 0;

        $registeredCourses = RegisteredCourse::where('year', $data['year'])->where('semester', $data['semester'])->where('user_id', $data['user_id'])->get();
        $courseResults = CourseResult::where('year', $data['year'])->where('semester', $data['semester'])->where('user_id', $data['user_id'])->get();

        if(count($registeredCourses) == count($courseResults)){
            foreach($courseResults as $result){
                $course = Course::find($result->course_id);
                $courseresult = CourseResult::where('year', $data['year'])->where('semester', $data['semester'])->where('user_id', $data['user_id'])->where('course_id', $course->id)->first();
                $grade_point = $courseresult->grade_point;
                $totalects = $totalects + $course->ects;
                $sgp = $sgp + ($course->ects * $grade_point);
            }

        }

        $sgpa = sgpa::create([
            'user_id' => $data['user_id'],
            'year' => $data['year'],
            'semester' => $data['semester'],
            'sgp' => $sgp,
            'sgpa' =>$sgp/$totalects,
        ]);

        return response($sgpa);
    }
}
