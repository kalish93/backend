<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "email" => "admin@gmail.com",
            "password" => bcrypt("12345678"),
            "first_name" => "john",
            "last_name" => "doe",
            "middle_name" => "abebe",
            "role" => "Admin"
        ]);

    }
}
