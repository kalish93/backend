<?php

namespace App\Http\Controllers;

use App\Models\CourseResult;
use Illuminate\Http\Request;

class CourseResultController extends Controller
{
    //

    public function getResults($student_id){
        $results = CourseResult::where('user_id', $student_id)->get();

        // $years = [];

        // foreach($results as $result){
        //     if(in_array($result['year'],$years)){
        //         continue;
        //     }else{
        //         array_push($years, $result['year']);
        //     }

        // }

        // sort($years);

        // $results = [];
        // foreach($years as $year){
        //     $sem1 = CourseResult::where('year', $year)->where('semester', 1)->get();
        //     $sem2 = CourseResult::where('year', $year)->where('semester', 2)->get();
        //     $res1 = [];
        //     $res2 = [];

        //     foreach($sem1 as $sem){
        //         array_push($res1, [
        //             'course_id' => $sem['course_id'],
        //             'grade' => $sem['grade'],
        //         ]);
        //     }
        //     array_push($results, [
        //         'year' => $year,
        //         'semester' => 1,
        //         'result' => $res1
        //     ]);
        //     foreach($sem2 as $sem){
        //         array_push($res2, [
        //             'course_id' => $sem['course_id'],
        //             'grade' => $sem['grade'],
        //         ]);
        //     }
        //     array_push($results, [
        //         'year' => $year,
        //         'semester' => 2,
        //         'result' => $res2
        //     ]);

        // }

        return response($results);
    }


}
