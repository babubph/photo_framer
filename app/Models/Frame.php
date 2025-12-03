<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
     protected $fillable = [
        'frame_name',
        'frame_image',
        'status',
    ];

}
