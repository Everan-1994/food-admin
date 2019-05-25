<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnBrand extends Model
{
    protected $fillable = [
        'goods_name', 'goods_type', 'goods_img', 'images_url', 'goods_intro', 'goods_content'
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
