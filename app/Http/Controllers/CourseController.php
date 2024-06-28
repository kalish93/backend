<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //


    public function index(){
        return Course::all();
    }

    public function store(Request $request){
        $data = $request->validate([
            'course_name' => 'required|string',
            'course_code' => 'required|string',
            'ects' => 'required|integer',
            'credit_hours' => 'required|integer',
            'description' => 'string|required',
            'prerequisites' => 'array|nullable',
            'department' => 'required',
            'program' => 'required'
        ]);

        $course = Course::create([
            'course_name' => $data['course_name'],
            'course_code' => $data['course_code'],
            'ects' => $data['ects'],
            'credit_hours' => $data['credit_hours'],
            'description' => $data['description'],
            'department' => $data['department'],
            'program' => $data['program']
        ]);

        foreach($data['prerequisites'] as $prerequisite){
            $course->prerequisites()->attach($prerequisite);
        }

        return response($course);
    }

    public function show($id){
        $course = Course::find($id);
        return response($course);
    }

    public function courses($program, $depatrment){
        $courses = Course::where('program', $program)->where('department', $depatrment)->get();
        return response($courses);
    }
}
