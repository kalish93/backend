<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgpa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'semester',
        'sgp',
        'sgpa',
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
