<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardCopyBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'edition',
        'subject'
    ];
}
