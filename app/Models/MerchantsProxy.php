<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantsProxy extends Model
{
    protected $fillable = [
        'name', 'contact', 'tel', 'address', 'business_license', 'range'
    ];
}
