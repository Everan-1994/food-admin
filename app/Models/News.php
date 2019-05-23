<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    static $newsType = [
        '企业新闻',
        '行业新闻',
        '展会新闻',
    ];

    protected $fillable = [
        'type', 'resource_type', 'title', 'image', 'video', 'content',
    ];
}
