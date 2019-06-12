<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'title', 'content', 'resource_type', 'image', 'video'
    ];
}
