<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandCooperation extends Model
{
    protected $fillable = [
        'name', 'content', 'logo', 'images_url',
         'company_name', 'contact', 'tel', 'address'
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
