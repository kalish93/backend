<?php

namespace App\Http\Controllers;

use App\Models\CourseResult;
use App\Models\DetailResult;
use Illuminate\Http\Request;

class DetailResultController extends Controller
{
    //

    public function createDetailResult(Request $request){
        $datas = $request->validate([
            // 'out_of' => 'required|integer',
            // 'value' => 'required|integer',
            // 'user_id' => 'required',
            // 'course_id' => 'required',
            // 'detail_results' => 'required|array',
            'datas' => 'required|array'
        ]);


        $course_results = [];

        foreach($datas['datas'] as $data){
            $total = 0;
            foreach($data['detail_results'] as $result){
                if($result['value'] > $result['out_of'] || $result['value'] > 100 || $result['out_of'] < 0){
                    return response(['message'=> 'please enter valid grade'],403);
                }elseif(CourseResult::where('course_id', $data['course_id'])->where('user_id', $data['user_id'])->first()){
                    continue;
                }else{
                    $result = DetailResult::create([
                        'out_of' => $result['out_of'],
                        'value' => $result['value'],
                        'user_id' => $data['user_id'],
                        'course_id' => $data['course_id']
                    ]);

                    array_push($course_results, $result);
                }

            $total = $total + $result['value'];
            }

            // foreach($course_results as $result){
            //     $total = $total + $result['value'];
            // }

            $grade = '';
            $grade_point = 0;
            if($total >= 90){
                $grade = 'A+';
                $grade_point = 4.0;
            }
            elseif($total >= 83){
                $grade = 'A';
                $grade_point = 4.0;
            }
            elseif($total >= 80){
                $grade = 'A-';
                $grade_point = 3.75;
            }
            elseif($total >= 75){
                $grade = 'B+';
                $grade_point = 3.5;
            }
            elseif($total >= 68){
                $grade = 'B';
                $grade_point = 3.0;
            }
            elseif($total >= 65){
                $grade = 'B-';
                $grade_point = 2.75;
            }
            elseif($total >= 60){
                $grade = 'C+';
                $grade_point = 2.5;
            }
            elseif($total >= 50){
                $grade = 'C';
                $grade_point = 2.0;
            }
            elseif($total >= 45){
                $grade = 'C-';
                $grade_point = 1.75;
            }
            elseif($total >= 40){
                $grade = 'D';
                $grade_point = 1.0;
            }else{
                $grade = 'F';
                $grade_point = 0.0;
            }

            $course_result = CourseResult::create([
                'user_id' => $data['user_id'],
                'course_id' => $data['course_id'],
                'total' => $total,
                'grade' => $grade,
                'grade_point' => $grade_point
            ]);


        }
        return response([
            'total' => $course_result,
            'detail' => $course_results
        ]);
    }
}
