<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureVideo extends Model
{
    protected $fillable = [
        'brand_image', 'brand_video'
    ];

    public function setBrandImageAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['brand_image'] = json_encode($images);
        }
    }

    public function getBrandImageAttribute($images)
    {
        return json_decode($images, true);
    }

    public function setBrandVideoAttribute($video)
    {
        if (is_array($video)) {
            $this->attributes['brand_video'] = json_encode($video);
        }
    }

    public function getBrandVideoAttribute($video)
    {
        return json_decode($video, true);
    }
}
