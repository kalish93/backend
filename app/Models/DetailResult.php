<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'out_of',
        'value',
        'user_id',
        'course_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
