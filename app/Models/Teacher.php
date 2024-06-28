<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution',
        'specialization',
        'academic_rank',
        'phone_number',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
