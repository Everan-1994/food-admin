<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandIntro extends Model
{
    protected $fillable = [
        'title', 'intro', 'feature', 'idea', 'is_show'
    ];
}
