<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisteredCourse;
use Illuminate\Support\Facades\Auth;

class RegisteredCourseController extends Controller
{
    //

    public function courseRegistration(Request $request){
        $data = $request->validate([
            'course_ids' => 'required|array',
            'year' => 'required',
            'semester' => 'required'
        ]);

        foreach($data['course_ids'] as $id){
            RegisteredCourse::create([
                'course_id' => $id,
                'year' => $data['year'],
                'semester' => $data['semester'],
                'user_id' => Auth::user()->id
            ]);
        }

        return response(["message"=> "registered successfully"]);
    }
}
