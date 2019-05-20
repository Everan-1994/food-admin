<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperationReview extends Model
{
    protected $fillable = [
        'title', 'user_name', 'user_tel', 'user_email', 'user_address', 'user_message', 'images_url'
    ];

    public function getImagesUrlAttribute($images)
    {
        return json_decode($images, true);
    }
}
