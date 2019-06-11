<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandCooperation extends Model
{
    protected $fillable = [
        'name', 'content', 'logo', 'logo_hover', 'video',
         'company_name', 'contact', 'tel', 'address', 'is_show', 'sort'
    ];

//    public function setImagesUrlAttribute($images)
//    {
//        if (is_array($images))n {
//            $this->attributes['images_url'] = json_encode($images);
//        }
//    }
//
//    public function getImagesUrlAttribute($images)
//    {
//        return json_decode($images, true);
//    }
}
