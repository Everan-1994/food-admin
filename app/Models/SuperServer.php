<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperServer extends Model
{
    protected $fillable = [
        'content', 'images_url'
    ];

    public function setImagesUrlAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images_url'] = json_encode($images);
        }
    }

    public function getImagesUrlAttribute($images)
    {
        return json_decode($images, true);
    }
}
