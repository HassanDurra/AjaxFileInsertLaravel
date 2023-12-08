<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'sessionId'
    ];
}
