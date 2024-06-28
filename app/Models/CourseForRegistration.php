<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseForRegistration extends Model
{
    use HasFactory;

    protected $table = 'courses_for_registration';

    protected $fillable = [
        'year',
        'semester',
        'course_id',
        'end_date',
        'program',
        'department'
    ];

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
