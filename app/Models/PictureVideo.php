<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureVideo extends Model
{
    protected $fillable = [
        'brand_image', 'brand_video'
    ];

    public function setBrandImageAttribute($brand_image)
    {
        if (is_array($brand_image)) {
            $this->attributes['brand_image'] = json_encode($brand_image);
        }
    }

    public function getBrandImageAttribute($brand_image)
    {
        return json_decode($brand_image, true);
    }

    public function setBrandVideoAttribute($brand_video)
    {
        if (is_array($brand_video)) {
            $this->attributes['brand_video'] = json_encode($brand_video);
        }
    }

    public function getBrandVideoAttribute($brand_video)
    {
        return json_decode($brand_video, true);
    }
}
