<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnBrand extends Model
{
    protected $fillable = [
        'goods_name', 'goods_type', 'goods_img', 'goods_intro'
    ];
}
