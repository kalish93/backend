<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'department',
        'role',
        'year',
        'password',
        'program',
        'section'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }



    public function books(){
        return $this->hasMany(Book::class);
    }


    public function registeredCourses(){
        return $this->hasMany(RegisteredCourse::class);
    }


    public function cgpa(){
        return $this->hasOne(cgpa::class);
    }
    public function sgpa(){
        return $this->hasMany(cgpa::class);
    }

    public function courseResult(){
        return $this->hasMany(CourseResult::class);
    }

    public function detailResult(){
        return $this->hasMany(DetailResult::class);
    }

    // public function assignedCourses(){
    //     return $this->belongsToMany(Course::class, 'assigned_courses','teacher_id', 'course_id');
    // }


    public function assignedCourses(){
        return $this->hasMany(AssignedCourse::class,'teacher_id');
    }

    public function student(){
        return $this->hasOne(Student::class);
    }
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }


}







