<?php

namespace App\Http\Controllers;

use App\Models\cgpa;
use App\Models\sgpa;
use App\Models\Course;
use App\Models\CourseResult;
use Illuminate\Http\Request;
use App\Models\RegisteredCourse;

class cgpaController extends Controller
{
    //

    public function calculateCGPA(Request $request){
        $registeredCourses = RegisteredCourse::where('user_id', $request->user_id)->get();

        $totalects = 0;
        $cgp = 0;

        $courseResults = CourseResult::where('user_id', $request->user_id)->get();

        foreach($courseResults as $result){
            $course = Course::find($result->course_id);
            $courseresult = CourseResult::where('user_id', $request->user_id)->where('course_id', $course->id)->first();
            $cgp = $courseresult->grade_point;
            $totalects =  $totalects + $course->ects;
        }

        $cgpa = cgpa::create([
            'user_id' => $request->user_id,
            'cgp' => $cgp,
            'cgpa' => $cgp/$totalects,
        ]);

        return response($cgpa);
    }
}
