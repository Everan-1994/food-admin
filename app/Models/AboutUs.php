<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'title', 'content', 'resource_type', 'image', 'video'
    ];

    public function setImageAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['image'] = json_encode($images);
        }
    }

    public function getImageAttribute($images)
    {
        return json_decode($images, true);
    }
}
