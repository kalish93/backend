<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'ects',
        'credit_hours',
        'description',
        'year',
        'semester',
        'program',
        'department'
    ];

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'prerequisites', 'course_id', 'prerequisite_id');
    }

    public function courseForRegistration(){
        return $this->belongsTo(CourseForRegistration::class);
    }

    public function registeredCourse(){
        return $this->belongsTo(RegisteredCourse::class);
    }

    public function assignedCourse(){
        return $this->belongsToMany(User::class,'teacher_id');
    }
}
