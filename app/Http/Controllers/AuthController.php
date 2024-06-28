<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Rules\ValidUserData;
use Illuminate\Http\Request;
use App\Rules\ValidExcelFile;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
class AuthController extends Controller
{

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);

        $user = Auth::attempt($fields);
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            return response()->json([
                'message' => 'Incorrect email or password'
            ], 401);
        }
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            $token = auth()->claims([
            'user_id' => $user -> id,
            'email' =>   $user->email,
            'role' =>  $user->role,
        ])->attempt($fields);


        }else{
            return;
        }


        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }


    public function studentRegistration(Request $request){
        // $this->authorize("create_delete_users");
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'department'  => 'required|string',
            'year' => 'required|integer',
            'password' => 'required',
            'program' => 'required|string',
            'section' => 'required',
            'student_id'=> 'required|string'
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role'=> 'Student',
            'password' => bcrypt($data['password']),

        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'department'=> $data['department'],
            'year' => $data['year'],
            'program' => $data['program'],
            'section' => $data['section'],
            'student_id'=> $data['student_id']
        ]);

        return response($student);
    }

    public function teacherRegistration(Request $request){
        // $this->authorize("create_delete_users");

        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'institution' => 'required|string',
            'specialization' => 'required|string',
            'academic_rank' => 'required',
            'phone_number' => 'required'
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role'=> 'Teacher',
            'password' => bcrypt($data['password']),
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'institution' => $data['institution'],
            'specialization' => $data['specialization'],
            'academic_rank' => $data['academic_rank'],
            'phone_number' => $data['phone_number'],
        ]);

        return response($teacher);
    }

    public function registerStudentsFromExel(Request $request)
    {
        $users = Excel::toArray([], $request->file('file'))[0];
        $users = array_slice($users,1);

        foreach ($users as $user) {
            if($user[1]){
            $temp = User::create([
                'first_name' => $user[1],
                'middle_name' => $user[2],
                'last_name' => $user[3],
                'email' => $user[5],
                'role'=> 'Student',
                'password' => bcrypt($user[10]),
            ]);

            Student::create([
                'user_id' => $temp->id,
                'department'=> $user[6],
                'year' => $user[7],
                'program' => $user[9],
                'section' => $user[8],
                'student_id' => $user[4]
            ]);
            }
            else{
                continue;
            }
        }

        // Return a success response
        return response()->json(['message' => 'Users registered successfully.'], 200);
    }


    public function teachers(){
        $users = User::where('role', 'Teacher')->get();
        $data = [];
        foreach($users as $user){
            $teacher = Teacher::where('user_id', $user->id)->first();

            array_push($data, [
                'id'=>$user->id,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'institution' => $teacher->institution,
                'specialization' => $teacher->specialization,
                'academic_rank' => $teacher->academic_rank,
                'phone_number' => $teacher->phone_number,
            ]);
        }

        return response($data);
    }

    public function students(){
        return User::where('role', 'Student')->get();
    }

    public function getStudents($program, $department, $year){
        $users =  User::where('role', 'Student')->get();
        $data = [];
        foreach($users as $user){
            $student = Student::where('user_id',$user->id)
                                ->where('program', $program)
                                ->where('department', $department)
                                ->where('year', $year)
                                ->first();

            if($student){
                array_push($data,[
                    'id'=>$user->id,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'student_id' => $student->student_id,
                    'section' => $student->section,
                ]);
            }
        }

        return response($data);
    }

    public function profile(){
        $user = User::find(Auth::user()->id);
        $student = Student::where('user_id', Auth::user()->id)->first();
        $teacher = Teacher::where('user_id', Auth::user()->id)->first();

        if($student){
           $user['section'] = $student['section'];
           $user['year'] = $student['year'];
           $user['program'] = $student['program'];
           $user['department'] = $student['department'];
        } elseif($teacher){
            $user['academic_rank'] = $teacher['academic_rank'];
            $user['phone_number'] = $teacher['phone_number'];
            $user['institution'] = $teacher['institution'];
            $user['specialization'] = $teacher['specialization'];
        }

        return response($user);
    }

    public function downloadStudentTemplate()
    {
        // Define the headers for the Excel file
        $headers = [
            'No.',
            'First Name',
            'Middle Name',
            'Last Name',
            'Student ID',
            'Email',
            'Department',
            'Year',
            'Section',
            'Program',
            'Password',
        ];

        // Example data row (optional)
        $exampleRow = [
            '1',
            'John',
            'Doe',
            'Smith',
            '12345',
            'john.doe@example.com',
            'Computer Science',
            '2023',
            'A',
            'BSc Computer Science',
            'password123', // Optional: Provide a default password example
        ];

        // Create a collection for the data (here, just one example row)
        $data = collect([$exampleRow]);

        // Generate and return the Excel download
        return Excel::download(new class($data, $headers) implements FromCollection, WithHeadings {
            protected $data;
            protected $headers;

            public function __construct($data, $headers)
            {
                $this->data = $data;
                $this->headers = $headers;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headers;
            }
        }, 'student_registration_template.xlsx');
    }
}
