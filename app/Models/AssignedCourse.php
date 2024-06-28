<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedCourse extends Model
{
    use HasFactory;

    protected $table = 'assigned_courses';

    protected $fillable = [
        'teacher_id',
        'course_id',
        'section',
        'program',
        'department',
        'year'
    ];

    public function teacher(){
        return $this->belongsToMany(User::class, 'teacher_id');
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
