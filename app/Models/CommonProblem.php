<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonProblem extends Model
{
    protected $fillable = [
        'question', 'answer', 'is_show', 'sort'
    ];
}
