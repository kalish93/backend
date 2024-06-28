<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return User::create([
            //
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'department' => $row['department'],
            'year' => (int)$row['year'],
            'section' => (int)$row['section'],
            'program' => $row['program'],
            'password' => bcrypt($row[ 'password']),
            'role' => 'Student'
        ]);
    }
}
