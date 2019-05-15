<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    protected $fillable = [
        'logo', 'name', 'tel', 'address', 'wx_qrcode', 'kf_qrcode'
    ];
}
