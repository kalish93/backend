<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredCourse extends Model
{
    use HasFactory;

    protected $table = 'registered_courses';

    protected $fillable = [
        'user_id',
        'course_id',
        'year',
        'semester'
    ];


    public function course(){
        return $this->hasOne(Course::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
