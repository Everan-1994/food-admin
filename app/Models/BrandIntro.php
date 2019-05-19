<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandIntro extends Model
{
    protected $fillable = [
        'intro', 'feature', 'idea', 'brand_image', 'brand_video'
    ];
}
