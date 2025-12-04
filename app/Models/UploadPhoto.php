<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadPhoto extends Model
{
     protected $fillable = [
        'cdate',
        'photo_id',
        'photo',
    ];
}
