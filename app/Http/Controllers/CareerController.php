<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    //
    public function store(Request $request){
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email'=> 'required|string',
            'institution'=> 'required|string',
            'specialization'=> 'required|string',
            'academic_rank'=> 'required|string',
            'phone_number'=> 'required|string',
            'resume'=> 'required'
        ]);

        $file = $request->file('resume');
        $fileName = time().'.'.$file->extension();
        $file->move(public_path('files'), $fileName);

        $career = Career::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'institution' => $data['institution'],
            'specialization' => $data['specialization'],
            'academic_rank' => $data['academic_rank'],
            'phone_number' => $data['phone_number'],
            'resume' => '/files/' . $fileName,
        ]);
    }

    public function getAll(){
        return Career::all();
    }

    public function destroy($id){
        $career = Career::find($id);
        $career->delete();

        return response(['message'=> 'career deleted successfully']);
    }
}
