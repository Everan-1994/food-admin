<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCulture extends Model
{
    protected $fillable = [
        'name', 'en_name', 'image_url', 'content'
    ];
}
