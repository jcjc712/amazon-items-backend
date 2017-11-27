<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'item_media';
    protected $fillable = [
        'item_id',
        'mediumImage',
        'largeImage'
    ];
}
